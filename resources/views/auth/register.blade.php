@extends('master')

@section('content')
    <div class="card col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <div class="card-header">
            <h2>Register
                <small></small>
            </h2>
        </div>
        @include('errors.show')

        <form method="POST" action="{{ url('auth/register') }}">
            {!! csrf_field() !!}
            <div class=" card-body card-padding">
                <div class="form-group  fg-float">
                    <div class="fg-line">
                        <input type="email" class="form-control input-sm fg-input" name="email"
                               value="{{ old('email') }}">
                    </div>
                    <label class="fg-label">Email address</label>
                </div>
                <div class="form-group  fg-float">
                    <div class="fg-line">
                        <input type="password" class="form-control input-sm fg-input" name="password"
                               id="exampleInputPassword1">
                    </div>
                    <label class="fg-label">Password</label>
                </div>
                <div class="form-group  fg-float">
                    <div class="fg-line">
                        <input type="password" class="form-control input-sm fg-input" name="password_confirmation">
                    </div>
                    <label class="fg-label" for="exampleInputPassword1">Confirm Password</label>
                </div>
                <button type="submit"
                        class="btn btn-block btn-primary m-t-10 waves-effect waves-button waves-float">
                    Register
                </button>
                <div class="form-group p-t-15">
                    <a href="{{url('auth/facebook')}}" class="btn btn-block btn-social btn-facebook">
                        Register with Facebook
                    </a>
                </div>
            </div>
        </form>
    </div>


@stop