<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Bio;
use App\User;
use App\PaperSize;

use App\Classes\DocumentPDF\PDF;
use DB;
use DateTime;
use DateInterval;
use DatePeriod;

class DocPrintingController extends Controller
{
    public function init(Request $request, $documentType) {
        $key = strtolower($request->key);
        $previewToggle = strtolower($request->toggle);
        $paperType = $request->papertype;
        $paper = PaperSize::where('id', $paperType)->first();

        switch ($documentType) {
            case 'dtr':
                $dateFrom = $request->datefrom;
                $dateTo = $request->dateto;

                //dd([$key, $previewToggle, $paperType, $dateFrom, $dateTo]);

                $pageDimension = [$paper->width, $paper->height];
                $userDat = User::where('bio_id', $key)->first();

                if ($userDat) {
                    $data = $this->getDailyTimeRecord_Data($userDat, $dateFrom, $dateTo);
                    $this->printDTR($data, $documentType, $pageDimension, $previewToggle);
                } else {
                    return 'Employee is not registered in the system.';
                }

                break;

            default:
                # code...
                break;
        }
    }

    private function getUserData($id) {
        $user = DB::table('users as emp')
                  ->select('emp.first_name', 'emp.mid_name', 'emp.last_name',
                           'div.immediate_sup', 'emp.division_id')
                  ->leftJoin('division as div', 'div.id', '=', 'emp.division_id')
                  ->where('emp.id', $id)
                  ->orWhere('emp.emp_id', $id)
                  ->orWhere('emp.bio_id', $id)
                  ->first();

        if ($user) {
            $immedSup = User::where('id', $user->immediate_sup)->first();
            $firstname = strtoupper($user->first_name);
            $middlename = strtoupper($user->mid_name);
            $lastname = strtoupper($user->last_name);
            $position = "";

            if (empty($middlename)) {
                $fullname = "$firstname $lastname";
            } else {
                $fullname = "$firstname " . $middlename[0] . ". $lastname";
            }
        } else {
            $fullname = "";
            $position = "";
        }

        if (isset($immedSup) && $immedSup) {
            $firstname = strtoupper($immedSup->first_name);
            $middlename = strtoupper($immedSup->mid_name);
            $lastname = strtoupper($immedSup->last_name);
            $immedPosition = "";

            if (empty($middlename)) {
                $immedFullname = "$firstname $lastname";
            } else {
                $immedFullname = "$firstname " . $middlename[0] . ". $lastname";
            }

        } else {
            $immedFullname = "";
            $immedPosition = "";
        }

        return (object) ['name' => $fullname,
                         'position' => $position,
                         'name_immediate' => $immedFullname,
                         'position_immediate' => $immedPosition];
    }

    private function getBiometrics_Range_Data($userID, $dateFrom, $dateTo) {
        $data = Bio::where('user_id', $userID)
                   ->whereBetween(DB::Raw('DATE(date_log)'), [$dateFrom, $dateTo])
                   ->orderBy('date_log')
                   ->get();

        return $data;
    }

    private function getDateRange_Array($dateFrom, $dateTo) {
        $begin = new DateTime($dateFrom);
        $end = new DateTime($dateTo);
        $end->setTime(0, 0, 1);
        $interval = new DateInterval('P1D'); // 1 Day
        $dateRange = new DatePeriod($begin, $interval, $end);

        return (object) ['date_from' => $begin,
                         'date_to' => $end,
                         'date_range' => $dateRange];
    }

    private function getFormattedDateRange($dateArray) {
        $countDateRange = count($dateArray);
        $dateFrom =  new DateTime($dateArray[0]);
        $dateTo =  new DateTime($dateArray[$countDateRange - 1]);

        $month = strtoupper($dateFrom->format('F'));
        $dStart = $dateFrom->format('j');
        $dEnd = $dateTo->format('j');
        $year = $dateFrom->format('Y');

        $mDateStart = date('Y-m-01', strtotime($dateFrom->format('Y-m-d')));
        $mDateEnd = date('Y-m-t', strtotime($dateFrom->format('Y-m-d')));
        $mListDate = $this->getDateRange_Array($mDateStart, $mDateEnd);
        $mListDateArray = [];

        foreach ($mListDate->date_range as $date) {
            $mListDateArray[] = $date->format('Y-m-d');
        }

        $countTotalDay = $dateFrom->format('t');

        if ($dStart != $dEnd) {
            $fDateRange = "$month $dStart-$dEnd, $year";
        } else {
            $fDateRange = "$month $dStart, $year";
        }

        return (object) ['f_date_range' => $fDateRange,
                         'total_day' => $countTotalDay,
                         'm_list_date' => $mListDateArray];
    }

    private function getDailyTimeRecord_Data($userDat, $dateFrom, $dateTo) {
        $dateRange = $this->getDateRange_Array($dateFrom, $dateTo);
        $biometrics = $this->getBiometrics_Range_Data(
            $userDat->bio_id,  $dateRange->date_from->format('Y-m-d'),  $dateRange->date_to->format('Y-m-d'));
        $dateArray = [];

        foreach ($dateRange->date_range as $date) {
            $date = $date->format('Y-m-d');
            $dateArray[] = $date;
        }

        return (object) ['list_date' => $dateArray,
                         'dtr' => $biometrics,
                         'bio_id' => $userDat->bio_id,
                         'user_id' => $userDat->id];
    }

    private function setDocumentInfo($pdf, $docTitle, $docCreator = "DOST-CAR",
                                     $docAuthor = "DOST-CAR", $docSubject = "",
                                     $docKeywords = "") {
        //Main information
        $pdf->SetTitle($docTitle);
        $pdf->SetCreator($docCreator);
        $pdf->SetAuthor($docAuthor);
        $pdf->SetSubject($docSubject);
        $pdf->SetKeywords($docKeywords);
    }

    private function printDocument($pdf, $docTitle, $previewToggle) {
        if ($previewToggle == 'download') {
            $pdf->Output($docTitle . '.pdf', 'D');
        } else if ($previewToggle == 'preview'){
            $pdf->Output($docTitle . '.pdf', 'I');
        }
    }

    /*---Printing of documents---*/

    private function printDTR($data, $documentType, $pageDimension, $previewToggle) {
        $pdf = new PDF('P', 'mm', $pageDimension);
        $pdf->setHeaderLR(false, false);
        $docTitle = $documentType . "_" . $data->bio_id;
        $docCreator = "DOST-CAR";
        $docAuthor = "DOST-CAR";
        $docSubject = "DTR";
        $docKeywords = "DTR, dtr, daily, time, record, daily time record";

        $fDateRange = $this->getFormattedDateRange($data->list_date)->f_date_range;
        $empName = $this->getUserData($data->user_id)->name;
        $immediateSup = $this->getUserData($data->user_id)->name_immediate;

        $totalDay = $this->getFormattedDateRange($data->list_date)->total_day;
        $monthListDate = $this->getFormattedDateRange($data->list_date)->m_list_date;
        $currentDay = 0;

        //Set document information
        $this->setDocumentInfo($pdf, $docTitle, $docCreator, $docAuthor,
                               $docSubject, $docKeywords);

        //Main document generation code file
        include app_path() . "/Classes/DocumentPDF/Documents/doc_daily_time_record.php";

        //Print the document
        $this->printDocument($pdf, $docTitle, $previewToggle);
    }
}
