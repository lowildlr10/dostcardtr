<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomLoginController extends Controller
{
    public function showLoginForm()

    {

        return view('custom.customLogin');

    }

    /* @POST

*/

public function login(Request $request){

    $this->validate($request, [

        'user_name' => 'required',

        'password' => 'required',

        ]);

    if (\Auth::attempt([

        'user_name' => $request->user_name,

        'password' => $request->password])

    ){

        return redirect('/dtr');

    }

    return redirect('/customLogin')->with('error', 'Invalid Email address or Password');

}

/* GET

*/

public function logout(Request $request)

{

    if(\Auth::check())

    {

        \Auth::logout();

        $request->session()->invalidate();

    }

    return  redirect('/customLogin');

}

}
