<?php

namespace App\Services;

use App\Bio;
use DB;
use DateTime;
use DateInterval;
use DatePeriod;

class BioSyncService {
    private $syncType;
    private $userID;
    private $dateFrom;
    private $dateTo;

    public function __construct() {

    }

    Public function init($syncType, $userID = NULL, $dateFrom = NULL, $dateTo = NULL) {
        $this->userID = $userID;

        switch ($syncType) {
            case 'daily':
                $this->syncType = 'ranged';
                $this->dateFrom = date('Y-m-d');
                $this->dateTo = date('Y-m-d');
                break;
            case 'all':
                if (!empty($dateFrom) && !empty($dateTo)) {
                    $this->syncType = 'ranged';
                    $this->dateFrom = $dateFrom;
                    $this->dateTo = $dateTo;
                } else {
                    $this->syncType = 'all';
                }
                break;
        }

        try {
            $totatData = $this->syncBiomtricsDB();
            return "Success! $totatData total data processed.";
        } catch (\Throwable $th) {
            return 'Failed!';
        }
    }

    private function getDateRange_Array($dateFrom, $dateTo) {
        $begin = new DateTime($dateFrom);
        $end = new DateTime($dateTo);
        $end->modify('+1 day');
        $interval = new DateInterval('P1D'); // 1 Day
        $dateRange = new DatePeriod($begin, $interval, $end);

        return (object) ['date_from' => $begin,
                         'date_to' => $end,
                         'date_range' => $dateRange];
    }

    public function syncBiomtricsDB() {
        ini_set('max_execution_time', 0);
        $totalData = 0;
        $bioUser = DB::Connection('sqlsrv')
                     ->table('UserInfo')
                     ->select('UserCode', 'Userid');

        if (!empty($this->userID)) {
            $bioUser = $bioUser->where('Userid', $this->userID);
        }

        $bioUser = $bioUser->orderBy('UserCode')
                           ->distinct()
                           ->get();

        foreach ($bioUser as $user) {
            $userID = $user->Userid;
            $_data = DB::Connection('sqlsrv')
                       ->table('Checkinout')
                       ->select('Userid', 'CheckTime', 'CheckType')
                       ->where('Userid', $userID);

            if ($this->syncType == 'ranged') {
                $recDateFrom = $this->dateFrom;
                $recDateTo = $this->dateTo;
                $_data = $_data->whereBetween(DB::raw('CONVERT(DATE, CheckTime)'),
                                              [$recDateFrom, $recDateTo]);
            }

            $_data = $_data->orderBy('Userid')
                           ->orderByRaw('CONVERT(DATE, CheckTime)')
                           ->get();
            $_dataCount = $_data->count();

            $_data = DB::Connection('sqlsrv')
                       ->table('Checkinout')
                       ->select('Userid', 'CheckTime', 'CheckType')
                       ->get();

            if ($_dataCount > 0) {
                $dataFirst = $_data->first();
                $dataLast = $_data->last();
                $dateStart = new DateTime($dataFirst->CheckTime);
                $dateEnd = new DateTime($dataLast->CheckTime);
                $dateFrom = $dateStart->format('Y-m-d');
                $dateTo = $dateEnd->format('Y-m-d');
                $dateRange = $this->getDateRange_Array($dateFrom, $dateTo);

                foreach ($dateRange->date_range as $rDate) {
                    $date = $rDate->format('Y-m-d');
                    $bio = Bio::where([['user_id', $userID],
                                      [DB::raw('DATE(date_log)'), $date]])
                              ->first();

                    if (!$bio) {
                        $bio = new Bio;
                    }

                    $data = DB::Connection('sqlsrv')
                              ->table('Checkinout')
                              ->select('Userid', 'CheckTime', 'CheckType')
                              ->where([['Userid', $userID],
                                      [DB::raw('CONVERT(DATE, CheckTime)'), $date]])
                              ->orderBy('Userid')
                              ->orderByRaw('CONVERT(DATE, CheckTime)')
                              ->get();

                    if ($data->count() > 0) {
                        $bio->user_id = $userID;
                        $bio->date_log = $date;

                        $bioTimeInAM = NULL;
                        $bioTimeOutAM = NULL;
                        $bioTimeInPM = NULL;
                        $bioTimeOutPM = NULL;

                        $timeInAM = strtotime('11:59:00');
                        $timeInAM_IsChanged = false;
                        $timeOutAM = strtotime('12:59:00');
                        $timeOutAM_IsChanged = false;
                        $timeInPM = strtotime('16:59:00');
                        $timeInPM_IsChanged = false;
                        $timeOutPM = strtotime('23:59:00');
                        $timeOutPM_IsChanged = false;

                        foreach ($data as $dat) {
                            $datCheckTime = new DateTime($dat->CheckTime);
                            $datTime = strtotime($datCheckTime->format('H:i:s'));

                            // If AM (time in and out) & PM (time in and out) is present
                            if ($datTime < $timeInAM && empty($bioTimeInAM)) {
                                $bioTimeInAM = $datCheckTime->format('H:i:s');
                                $timeInAM = strtotime($bioTimeInAM);
                                $timeInAM_IsChanged = true;
                            }

                            if ($datTime > $timeInAM && $datTime < $timeOutAM &&
                                !empty($bioTimeInAM) && empty($bioTimeOutAM)) {
                                $_bioTimeInAM = date('H', $timeInAM);
                                $_bioTimeOutAM = date('H', strtotime($datCheckTime->format('H:i:s')));

                                if ($_bioTimeInAM != $_bioTimeOutAM) {
                                    $bioTimeOutAM = $datCheckTime->format('H:i:s');
                                    $timeOutAM = strtotime($bioTimeOutAM);
                                    $timeOutAM_IsChanged = true;
                                }
                            } else if ($datTime > $timeInAM && $datTime < $timeOutAM &&
                                       empty($bioTimeInAM) && empty($bioTimeOutAM)) {
                                $bioTimeOutAM = $datCheckTime->format('H:i:s');
                                $timeOutAM = strtotime($bioTimeOutAM);
                                $timeOutAM_IsChanged = true;
                            }

                            if ($datTime > $timeOutAM && $datTime < $timeInPM &&
                                !empty($bioTimeOutAM) && empty($bioTimeInPM)) {
                                $bioTimeInPM = $datCheckTime->format('H:i:s');
                                $timeInPM = strtotime($bioTimeInPM);
                                $timeInPM_IsChanged = true;
                            } else if ($datTime > $timeOutAM && $datTime < $timeInPM &&
                                       empty($bioTimeOutAM) && empty($bioTimeInPM)) {
                                $bioTimeInPM = $datCheckTime->format('H:i:s');
                                $timeInPM = strtotime($bioTimeInPM);
                                $timeInPM_IsChanged = true;
                            }

                            if ($datTime > $timeInPM && $datTime < $timeOutPM &&
                                !empty($bioTimeInPM) && empty($bioTimeOutPM)) {
                                $_bioTimeInPM = date('H', $timeInPM);
                                $_bioTimeOutPM = date('H', strtotime($datCheckTime->format('H:i:s')));

                                if ($_bioTimeInPM != $_bioTimeOutPM) {
                                    $bioTimeOutPM = $datCheckTime->format('H:i:s');
                                    $timeOutPM_IsChanged = true;
                                }
                            } else if ($datTime > $timeInPM && $datTime < $timeOutPM &&
                                       empty($bioTimeInPM) && empty($bioTimeOutPM)) {
                                $bioTimeOutPM = $datCheckTime->format('H:i:s');
                                $timeOutPM_IsChanged = true;

                                if (!$bioTimeInAM && !$bioTimeInPM) {
                                    $bioTimeInPM = $bioTimeOutAM;
                                    $bioTimeOutAM = NULL;
                                }
                            }
                        }

                        $bio->time_in_am = $bioTimeInAM;
                        $bio->time_out_am = $bioTimeOutAM;
                        $bio->time_in_pm = $bioTimeInPM;
                        $bio->time_out_pm = $bioTimeOutPM;

                        //dd([$data, $bio]);

                        $totalData++;

                        $bio->save();
                    }
                }
            }
        }

        return $totalData;
    }

}
