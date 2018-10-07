@extends('master')

@section('content')
    <div class="card">
        @include('errors.show')
        @include('success')
        <div class="card-header">
            <h2>{{ Auth::user()->name }}'s combat logs
                <small>
                    <p>See your attacks results, who attacked you, how it went and if they stole anything.</p>
                </small>
            </h2>
        </div>
        <div class="" tabindex="1" style="outline: none; ">
            <table class="table">
                <thead>
                <tr>
                    <th colspan="8" class="text-center">Attacks</th>
                </tr>
                <tr>
                    <th>Result</th>
                    <th>Enemy</th>
                    <th>Your damage</th>
                    <th>Enemy damage</th>
                    <th>Bank stolen</th>
                    <th>Gold stolen</th>
                    <th>Your injured</th>
                    <th>Enemy injured</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                @if (count($attacks) > 0 )
                    @foreach($attacks as $attack)
                        <tr class=@if($attack->result == 1) "won-row" @elseif ($attack->result == -1) "lost-row" @else
                            "" @endif>
                        <td>@if($attack->result == 1)<span
                                    class="won">You Won!</span> @elseif ($attack->result == -1) <span
                                    class="lost">You lost... </span>@else <span class="tie">It's a tie.</span>@endif
                        </td>
                        <td>
                            @if (App\User::find($attack->defender_id))
                                <a href="{{url('user/' .$attack->defender_id)}}">
                                    {{ App\User::find($attack->defender_id)->name  }}
                                </a>
                            @else
                                Player doesn't exist anymore
                            @endif
                        </td>
                        <td>{{GameInfo::formatNum($attack->attacker_damage)}}</td>
                        <td>{{GameInfo::formatNum($attack->defender_damage)}}</td>
                        <td>{{GameInfo::formatNum($attack->gold_stolen)}}</td>
                        <td>{{GameInfo::formatNum($attack->bank_stolen)}}</td>
                        <td>{{GameInfo::formatNum($attack->attacker_losses)}}</td>
                        <td>{{GameInfo::formatNum($attack->defender_losses)}}</td>
                        <td>{{$attack->created_at}}</td>
                        </tr>
                    @endforeach
                    {!! $attacks->render() !!}
                @else
                    <tr>
                        <td colspan="8">No attacks logged</td>
                    </tr>
                @endif
                </tbody>
                <thead>
                <tr>
                    <th colspan="8" class="text-center">Defenses</th>
                </tr>
                <tr>
                    <th>Result</th>
                    <th>Enemy</th>
                    <th>Your damage</th>
                    <th>Enemy damage</th>
                    <th>Gold stolen</th>
                    <th>Bank stolen</th>
                    <th>Your injured</th>
                    <th>Enemy injured</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                @if (count($defenses)>0)
                    @foreach($defenses as $defense)
                        <tr class=@if($defense->result == -1) "won-row" @elseif ($defense->result == 1) "lost-row" @else
                            "" @endif>
                        <td>@if($defense->result == -1) <span
                                    class="won">You Won!</span> @elseif ($defense->result == 1) <span
                                    class="lost">You lost...</span> @else <span class="tie">It's a tie.</span>@endif
                        </td>
                        <td>
                            @if (App\User::find($defense->defender_id))
                                <a href="{{url('user/' .$defense->attacker_id)}}">{{ App\User::find($defense->attacker_id)->name }}</a>
                            @else
                                Player doesn't exist anymore
                            @endif
                        </td>
                        <td>{{GameInfo::formatNum($defense->defender_damage)}}</td>
                        <td>{{GameInfo::formatNum($defense->attacker_damage)}}</td>
                        <td>{{GameInfo::formatNum($defense->gold_stolen )}}</td>
                        <td>{{GameInfo::formatNum($defense->bank_stolen )}}</td>
                        <td>{{GameInfo::formatNum($defense->defender_losses)}}</td>
                        <td>{{GameInfo::formatNum($defense->attacker_losses)}}</td>
                        <td>{{$defense->created_at }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8">No defenses logged</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
@stop