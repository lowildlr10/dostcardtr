@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">



                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">

                                                                @if (count($errors) > 0)

                                            <div class="alert alert-danger">



                                                <ul>

                                                    @foreach ($errors->all() as $error)

                                                    <li>{{ $error }}</li>

                                                    @endforeach

                                                </ul>

                                            </div>



                                            @endif



                                            @if ($message = Session::get('success'))

                                                <div class="alert alert-success">

                                                    <p>{{ $message }}</p>

                                                </div>

                                            @endif


                    <form method="POST" action="{{ route('custom.customRegister') }}">
                       {{csrf_field()}}

                        <div class="form-group row">
                            <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>

                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="f_name" autofocus>

                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="mid_name" class="col-md-4 col-form-label text-md-right">{{ __('Middle Name') }}</label>

                            <div class="col-md-6">
                                <input id="mid_name" type="text"  class="form-control" name="mid_name" value="{{ old('mid_name') }}" >

                                {{-- <!-- @error('mid_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror --> --}}
                            </div>
                        </div>

{{-- {{ dd($divisions, $users) }} --}}

                        <div class="form-group row">
                            <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name">

                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="gender" class="col-md-4 col-form-label text-md-right">{{ __('Gender') }} </label>

                                   <div class="col-md-6">
                                        <select class = "btn btn-default dropdown-toggle" value="{{ old('gender') }}" type="text" name = "gender" >
                                            <option value = ""></option>
                                            <option value = "1">Male</option>
                                            <option value = "2">Female</option>
                                        </select>
                                    </div>
                                @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        <div class="form-group row">
                            <label for="birthday" class="col-md-4 col-form-label text-md-right">{{ __('Date of Birth') }}</label>

                            <div class="col-md-6">
                                <input id="birthday" type="date" class="form-control @error('birthday') is-invalid @enderror" name="birthday" value="{{ old('birthday') }}" required autocomplete="mid_name">

                                @error('birthday')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                         <div class="form-group row">
                            <label for="mobile_no" class="col-md-4 col-form-label text-md-right">{{ __('Mobile No.') }}</label>

                            <div class="col-md-6">
                                <input id="mobile_no" type="text" class="form-control @error('mobile_no') is-invalid @enderror" name="mobile_no" value="{{ old('mobile_no') }}"  required autocomplete="mobile_no">

                                @error('mobile_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                         <div class="form-group row">
                            <label for="emp_status" class="col-md-4 col-form-label text-md-right">{{ __('Employment Status') }}</label>

                                   <div class="col-md-6">
                                        <select class = "btn btn-default dropdown-toggle"  value="{{ old('emp_status') }}" type="text" name="emp_status" >
                                            <option value = ""></option>
                                            <option value = "1">Permanent</option>
                                            <option value = "2">Contractual</option>
                                        </select>
                                    </div>
                                @error('emp_status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        <div class="form-group row">
                            <label for="position" class="col-md-4 col-form-label text-md-right">{{ __('Position') }}</label>

                            <div class="col-md-6">
                                <input id="position" type="text" class="form-control @error('position') is-invalid @enderror" name="position"  value="{{ old('position') }}" required autocomplete="position">

                                @error('position')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="unit_id" class="col-md-4 col-form-label text-md-right">{{ __('Unit') }}</label>

                            <div class="col-md-6">
                                    <select class = "btn btn-default dropdown-toggle"  type="text" name = "unit_id"  value="{{ old('unit_id') }}">

                                            <option value = ""></option>
                                            @foreach ($units as $unit)

                                                <option value="{{$unit->id }}">{{ $unit->unit_name }}</option>

                                            @endforeach
                                    </select>
                    </div>

                    @error('unit_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                     @enderror
                        </div>


                         <div class="form-group row">
                                <label for="office_id" class="col-md-4 col-form-label text-md-right">{{ __('Office') }}</label>
                                    <div class="col-md-6">
                                                    <select class = "btn btn-default dropdown-toggle"  type="text" name = "office_id" value="{{ old('office_id') }}" >
                                                            <option value = ""></option>
                                                        @foreach ($offices as $office)

                                                                <option value="{{$office->id }}">{{ $office->office_name }}</option>

                                                            @endforeach
                                                    </select>

                          </div>
                                @error('office_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                    <div class="form-group row">
                            <label for="division_id" class="col-md-4 col-form-label text-md-right">{{ __('Division') }}</label>

                                    <div class="col-md-6">
                                                    <select class = "btn btn-default dropdown-toggle"  type="text" name = "division_id" value="{{ old('division_id') }}" >
                                                            <option value = ""></option>
                                                            @foreach ($divisions as $division)

                                                                <option value="{{$division->id }}">{{ $division->division_name }}</option>

                                                            @endforeach
                                                    </select>
                                    </div>
                                @error('division_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group row">
                            <label for="user_name" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>

                            <div class="col-md-6">
                                <input id="user_name" type="text" class="form-control @error('user_name') is-invalid @enderror" name="user_name"  value="{{ old('user_name') }}" required autocomplete="user_name">

                                @error('user_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                         <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" name="email" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="emp_id" class="col-md-4 col-form-label text-md-right">{{ __('Employee ID No.') }}</label>

                            <div class="col-md-6">
                                <input id="emp_id" type="text" class="form-control @error('emp_id') is-invalid @enderror" value="{{ old('emp_id') }}" name="emp_id" required autocomplete="emp_id">

                                @error('emp_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="bio_id" class="col-md-4 col-form-label text-md-right">{{ __('Bio No.') }}</label>

                            <div class="col-md-6">
                                <input id="bio_id" type="text" class="form-control @error('bio_id') is-invalid @enderror" value="{{ old('bio_id') }}" name="bio_id" required autocomplete="bio_id">

                                @error('bio_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

<!----------------------------   hidden ---------------->

{{-- <input id="user_role" type="hidden"  value="4" name="user_role" > --}}



                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required ="password" >

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="confirm_password" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="confirm_password" type="password" class="form-control @error('confirm_password') is-invalid @enderror" name="confirm_password" required ="password" >
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
