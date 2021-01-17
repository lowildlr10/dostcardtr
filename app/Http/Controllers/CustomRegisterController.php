<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Division;
use App\Office;
use App\Unit;

use DB;


class CustomRegisterController extends Controller
{


    public function showRegisterForm()
    {
        $divisions = Division::orderBy('division_name')
        ->get();
        $offices = Office::orderBy('office_name')
            ->get();
        $units = Unit::orderBy('unit_name')
        ->get();
        $users = User::orderBy('last_name')
        ->get();



        return view('custom.customRegister',['divisions' => $divisions,
        'offices' => $offices, 'units' => $units, 'users' => $users] );
    }

    public function register()
    {
        request()->validate([
            'first_name' => 'required|max:50',
            'mid_name' => 'max:50',
            'last_name' => 'required|max:50',
            'position' => 'required||max:50',
            'gender' => 'required|max:50',
            'birthday' => 'required|max:50',
            'user_name' => 'required|max:50',
            'mobile_no' => 'required|max:11',
            'email' => 'required|email|unique:users',
            'emp_status' => 'required|max:50',
            'emp_id' => 'required|max:8',
            'bio_id' => 'required|max:8',
            'office_id' => 'required',
            'division_id' => 'required',
            'unit_id' => 'required',
            'password' => 'required|max:10',
            'confirm_password' => 'required|max:10|same:password',
        ], [

            'name.required' => 'Name is required',

            'name.min' => 'Name must be at least 2 characters.',

            'name.max' => 'Name should not be greater than 50 characters.',

        ]);

        $input = request()->except('password','confirm_password');
        $user=new User($input);
        $user->user_role = 4;
        $user->password=bcrypt(request()->password);
        $user->save();
        return back()->with('success', 'User created successfully.');

    /////////////////////////////////////////////////////////////////////////
    //     $this->validation($request);

    //    $user = new User;
    //    $this->validation($request);
    //    $user->first_name = $request->first_name;
    //    $user->mid_name = $request->mid_name;
    //    $user->last_name = $request->last_name;
    //    $user->position = $request->position;
    //    $user->gender = $request->gender;
    //    $user->birthday = $request->birthday;
    //    $user->user_name = $request->user_name;
    //    $user->mobile_no = $request->mobile_no;
    //    $user->email = $request->email;
    //    $user->emp_status = $request->emp_status;
    //    $user->emp_id = $request->emp_id;
    //    $user->bio_id = $request->bio_id;
    //    $user->office_id = $request->office_id;
    //    $user->division_id = $request->division_id;
    //    $user->unit_id = $request->unit_id;
    //    $user->password = bcrypt($request->password);
    //    $user->user_role = 4;


    //    $user->save();


    //    dd($user);
       //User:: create($request->all());

    //    return redirect('pages.dtr')->with('Status','You are registered');

        // $this->validator($request->all())->validate();

        // event(new Registered($user = $this->create($request->all())));

        // //$this->guard()->login($user);

        // dd($request);

        // return $this->registered($request, $user)
        //                 ?: redirect($this->redirectPath());


    }

    // public function validation($request)
    // {
    //     return $this->validate($request, [
    //         'first_name' => ['required', 'string', 'max:255'],
    //         'last_name' => ['required', 'string', 'max:255'],
    //         'position' => ['required', 'string', 'max:255'],
    //         'birthday' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    //         'emp_status' => ['required', 'string', 'max:255', 'unique:users'],
    //         'emp_id' => ['required', 'string', 'max:255', 'unique:users'],
    //         'bio_id' => ['required', 'string', 'max:255', 'unique:users'],
    //         'gender' => ['required', 'string', 'max:255'],
    //         'user_role' => ['required', 'string', 'max:255'],
    //         'office_id' => ['required', 'string', 'max:255'],
    //         'division_id' => ['required', 'string', 'max:255'],
    //         'unit_id' => ['required', 'string', 'max:255'],
    //         'user_name' => ['required', 'string', 'max:255', 'unique:users'],
    //         'password' => ['required', 'string', 'min:8', 'confirmed'],
    //     ]);
    // }

}
