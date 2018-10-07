@extends('master')

@section('content')
    @include('errors.show')
    @include('success')
    <div class="card">
        <div class="card-header">
            <h2>{{ Auth::user()->name }}'s ranking
                <small>
                    <p>See how you stand in each of your stats against other players.</p>
                </small>
            </h2>
        </div>
        <div class="col-md-12 bgm-white">
            <div class="col-md-12 text-center p-20 border">
                Overall Rank
            </div>
            <div class="col-md-12 text-center border p-20">
                @if (Auth::user()->ranking)
                    {{ Auth::user()->ranking->overall_rank }}
                @else
                    Unranked
                @endif
            </div>
            <div class="row border">
                <div class="col-xs-6 text-center p-20">
                    Attack Rank
                </div>
                <div class="col-xs-6 text-center p-20">
                    @if (Auth::user()->ranking)
                        {{ Auth::user()->ranking->attack_rank }}
                    @else
                        Unranked
                    @endif
                </div>
            </div>
            <div class="row">

                <div class="col-xs-6 text-center p-20">
                    Defense Rank
                </div>
                <div class="col-xs-6 text-center p-20">
                    @if (Auth::user()->ranking)
                        {{ Auth::user()->ranking->defense_rank }}
                    @else
                        Unranked
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop