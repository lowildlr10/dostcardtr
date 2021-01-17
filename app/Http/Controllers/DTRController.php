<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Division;
use App\Office;
use App\Agency;
use App\User;
use DB;
use Auth;

class DTRController extends Controller
{
    protected $agency;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->agency = Agency::where('is_set', 'y')->first();
    }

    public function showPageDTR(){
        $divisions = Division::orderBy('division_name')
                             ->get();
        $offices = Office::orderBy('office_name')
                         ->get();

        return view('pages.dtr', ['divisions' => $divisions,
                                  'offices' => $offices,
                                  'agency' => $this->agency]);
    }

    public function getDivision(Request $request, $officeID) {
        $dataDivision = Division::where('office_id', $officeID)
                                ->get();
        $divisions = [];

        foreach ($dataDivision as $division) {
            $divisions[] = (object) ['id' => $division->id,
                                     'division_name' => $division->division_name];
        }

        return json_encode($divisions);
    }

    public function getEmpList(Request $request) {
        $officeID = $request->officeid;
        $divisionID = $request->divisionid;
        $authUser = Auth::user();

        if (isset($authUser)) {
            if ($authUser->user_role == 1) {
                $whereArray = [['emp.office_id', $officeID],
                            ['emp.division_id', $divisionID],
                            ['emp.status', 'active']];
            } else if ($authUser->user_role == 2) {
                $whereArray = [['emp.office_id', $officeID],
                            ['emp.division_id', $divisionID],
                            ['emp.status', 'active'],
                            ['emp.user_role', '<>', 1]];
            } else if ($authUser->user_role == 3) {
                $officeID = $authUser->office_id;
                $divisionID = $authUser->division_id;
                $whereArray = [['emp.office_id', $officeID],
                            ['emp.division_id', $divisionID],
                            ['emp.status', 'active'],
                            ['emp.user_role', '<>', 1]];
            } else if ($authUser->user_role == 4) {
                $officeID = $authUser->office_id;
                $divisionID = $authUser->division_id;
                $whereArray = [['emp.id', $authUser->id],
                            ['emp.office_id', $officeID],
                            ['emp.division_id', $divisionID],
                            ['emp.status', 'active'],
                            ['emp.user_role', '<>', 1]];
            }
        } else {
            $whereArray = [['emp.office_id', $officeID],
                           ['emp.division_id', $divisionID],
                           ['emp.status', 'active']];
        }

        $employees = DB::table('users as emp')
                       ->select('emp.first_name', 'emp.mid_name', 'emp.last_name',
                                'emp.id', 'emp.bio_id', 'emp.office_id', 'emp.division_id',
                                'off.office_name', 'div.division_name')
                       ->join('division as div', 'div.id', '=', 'emp.division_id')
                       ->join('office as off', 'off.id', '=', 'emp.office_id')
                       ->where($whereArray)
                       ->orderBy('last_name')
                       ->get();

        return view('pages.view-dtr-employee', ['employees' => $employees]);
    }

    public function hashUserPasswords() {
        $users = User::all();

        foreach ($users as $user) {
            $user->password = bcrypt($user->password);
            $user->save();
        }
    }
}
