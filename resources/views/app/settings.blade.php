@extends('master')
@section('content')
    @include('errors.show')
    @include('success')
    <div class="card">
        <div class="card-header card-padding">
            <h2>Settings</h2>
            <small>
                Here you can modify your account settings.
            </small>
        </div>
        @if (!Auth::user()->activated)
            <div class="card-body card-padding">
                <h5>Activate your account: Choose a nickname and a faction to start playing!</h5>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                    Activate
                </button>
            </div>
        @endif
        @if (!Auth::user()->activated)
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Welcome!</h4>
                        </div>
                        <div class="modal-body">
                            <p>We need you to pick up a name and a race before playing!</p>

                            <form class="form-horizontal" role="form" action="{{ url('update-data') }}"
                                  method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <div class="col-md-4 col-md-offset-3">
                                        <input type="text" class="form-control"
                                               id="name" name="name" placeholder="Guest"/>
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <label class="radio-inline">
                                        <input type="radio" name="race" value="1">
                                        <i class="input-helper"></i>
                                        Reds
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="race" value="2">
                                        <i class="input-helper"></i>
                                        Blues
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="race" value="3">
                                        <i class="input-helper"></i>
                                        Greens
                                    </label>

                                    <label class="radio-inline">
                                        <input type="radio" name="race" value="4">
                                        <i class="input-helper"></i>
                                        Oranges
                                    </label>
                                </div>
                                <div class="form-group text-center">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-primary">Update!</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (Auth::user()->activated)
            <div class="card-body card-padding">
                <div class="col-md-12">
                    Race Changes Left: {{ Auth::user()->race_changes }}
                </div>
                <form class="form-horizontal" role="form" action="{{ url('update-race') }}"
                      method="post">
                    {{ csrf_field() }}
                    <div class="form-group text-center">
                        <label class="radio-inline">
                            <input type="radio" name="race" value="1" @if (Auth::user()->race_id == 1) checked @endif>
                            <i class="input-helper"></i>
                            Reds
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="race" value="2" @if (Auth::user()->race_id == 2) checked @endif>
                            <i class="input-helper"></i>
                            Blues
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="race" value="3" @if (Auth::user()->race_id == 3) checked @endif>
                            <i class="input-helper"></i>
                            Greens
                        </label>

                        <label class="radio-inline">
                            <input type="radio" name="race" value="4" @if (Auth::user()->race_id == 4) checked @endif>
                            <i class="input-helper"></i>
                            Oranges
                        </label>
                    </div>
                    <div class="form-group text-center">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary">Update!</button>
                        </div>
                    </div>
                </form>
            </div>
        @endif
    </div>
@stop