<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\User;
use App\Division;
use App\Office;
use App\Unit;
use DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'birthday' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'emp_status' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'max:255'],
            'office_id' => ['required', 'string', 'max:255'],
            'division_id' => ['required', 'string', 'max:255'],
            'unit_id' => ['required', 'string', 'max:255'],
            'user_name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function showRegistrationForm()
    {
        $divisions = Division::orderBy('division_name')
        ->get();
        $offices = Office::orderBy('office_name')
            ->get();
        $units = Unit::orderBy('unit_name')
        ->get();
        $users = User::orderBy('last_name')
        ->get();



        return view('auth.register',['divisions' => $divisions,
        'offices' => $offices, 'units' => $units, 'users' => $users] );
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        //$this->guard()->login($user);

        dd($request);

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }




    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */

    // {
    //     return User::all();
    //     return view('register');
    // }
    protected function create(array $data)
   {
        return User::create([
            'first_name' => $data['first_name'],
            'mid_name' => $data['mid_name'],
            'last_name' => $data['last_name'],
            'position' => $data['position'],
            'birthday' => $data['birthday'],
            'gender' => $data['gender'],
            'office_id' => $data['office_id'],
            'division_id' => $data['division_id'],
            'unit_id' => $data['unit_id'],
            'emp_status' => $data['emp_status'],
            'mobile_no' => $data['mobile_no'],
            'email' => $data['email'],
            'user_name' => $data['user_name'],
            'password' => Hash::make($data['password']),
        ]);


    }
}
