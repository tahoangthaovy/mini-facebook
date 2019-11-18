@extends('layouts.guest-layout')

@push('styles')
<link rel="stylesheet" type="text/css" href="/css/custom-register.css">
@endpush

@section('content')
<div class="register">
    <div class="container">
        <div class="row">
            <div class="col-md-7" style="padding-top: 30px;">
                <img src="/img/facebook_register.png" width="100%">
            </div>
            <div class="col-md-5">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div>
                            <div class="card-header">
                                <h2>{{ __('Register') }}</h2>
                                <p>Free all the time.</p>
                            </div>

                            <div class="card-body">
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf

                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder="Full Name" required autofocus>

                                            @if ($errors->has('name'))
                                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
{{--                                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>--}}

                                        <div class="col-md-12">
                                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email" required>

                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        {{--<label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>--}}

                                        <div class="col-md-12">
                                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password" name="password" required>

                                            @if ($errors->has('password'))
                                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        {{--<label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>--}}

                                        <div class="col-md-12">
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password"  required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-9">
                                            <input id="dob" type="date" class="form-control" name="dob" placeholder="DOB" required>
                                        </div>
                                        <label style="font-size: 20px" for="password-confirm" class="col-md-3 col-form-label">{{ __('DOB') }}</label>
                                    </div>

                                    <div class="form-group row" style="font-size: 20px;">
                                        <div class="col-md-12">
                                            <label class="radio-inline">
                                                <input type="radio" name="gender" value="male" checked>{{ __('Male') }}
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="gender" value="female">{{ __('Female') }}
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-12">
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
        </div>

    </div>
</div>

@endsection
