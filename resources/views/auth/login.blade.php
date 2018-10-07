@extends('master')

@section('content')
    <form method="post" action="{{ url('auth/login') }}">
        {!! csrf_field() !!}

        <div class="card col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="card-header">
                <h2>Login
                    <small></small>
                </h2>
            </div>
            @include('errors.show')
            <div class="card-body card-padding">
                <div class="form-group fg-line">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control input-sm" id="email" name="email"
                           value="{{ old('email') }}" placeholder="Enter email">
                </div>
                <div class="form-group fg-line">
                    <label for="password">Password</label>
                    <input type="password" class="form-control input-sm" name="password" id="password"
                           placeholder="Password">
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember"> Remember Me
                        <i class="input-helper"></i>
                    </label>
                </div>

                <button type="submit" name="login"
                        class="btn btn-block btn-primary m-t-10 waves-effect waves-button waves-float">
                    Login
                </button>
                <div class="form-group p-t-15">
                    <a href="{{url('auth/facebook')}}" class="btn btn-block btn-social btn-facebook">
                        Log in using Facebook
                    </a>
                </div>
            </div>
        </div>
    </form>
@stop


