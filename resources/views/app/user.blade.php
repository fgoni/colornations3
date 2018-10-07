@extends('master')

@section('content')
    <div class="card">
        <div class="table-responsive col-lg-6 col-lg-offset-3" tabindex="1" style="overflow: hidden; outline: none;">
            @include('errors.show')
            <form method="post" action="{{ url("attack") }}">
                {{ csrf_field() }}
                <table class="table">
                    <thead>
                    <tr>
                        <th colspan="2" class="text-center" id="{{$user->race_name}}">{{ $user->name }}</th>
                    </tr>
                    <tr>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Ranking</td>
                        <td>{{ $user->ranking ? $user->ranking->overall_rank : "Unranked" }}</td>
                    </tr>
                    <tr>
                        <td>Fortification</td>
                        <td>{{ GameInfo::fortToString($user->techs->fortification) }}</td>
                    </tr>
                    <tr>
                        <td>Units</td>
                        <td>{{ GameInfo::unitsForUser($user) }}</td>
                    </tr>
                    <tr>
                        <td>Gold</td>
                        <td>@if (Auth::check() && GameInfo::intelligenceForUser(Auth::user()) > GameInfo::intelligenceForUser($user))
                                {{ $user->resources->gold }}
                            @else
                                ???
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <input type="hidden" name="id" value="{{$user->id}}">
                        <td colspan="2">
                            <button type="submit" class="btn btn-primary">Attack!</button>
                            <button type="submit" class="btn btn-primary m-l-10" formaction="{{ url('spy') }}">Spy!</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
@stop