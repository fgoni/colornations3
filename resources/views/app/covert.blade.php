@extends('master')

@section('content')
    @include('errors.show')
    <div class="card">
        <div class="card-header">
            <p class="h2" style="color: #5E5E5E;">
                You infiltrated {{ $defender->name }}'s {{ GameInfo::fortToString($defender->techs->fortification) }}
            </p>
        </div>
        <div class="card-body card-padding">

            @if ($report->result == 1)
                <div class='battle'>
                    <p>
                        <span class='won big'>You won</span> the battle!<br/>
                    </p>

                    <p>
                        Your intelligence of <b>{{ number_format($attackerDamage) }}</b> triumphed over
                        <b>{{ number_format($defenderDamage) }}</b> security!<br/>
                    </p>

                    <p>
                        @foreach($intel as $key => $table)
                            @if ($key == 'units')
                                @foreach ($table as $key => $column)
                                    @if ($column != 0)
                                        Their {{ $key }} are {{ $column }} <br/>
                                    @endif
                                @endforeach
                            @elseif ($key == 'techs')
                                @foreach ($table as $key => $column)
                                    Their {{ ucfirst($key) }} Tech is
                                    @if ($key == 'siege')
                                        {{ GameInfo::siegeToString($column) }} (x{{ GameInfo::attackBonus($defender->techs->siege) }})
                                        <br/>
                                    @elseif ($key == 'fortification')
                                        {{ GameInfo::fortToString($column) }} (x{{ GameInfo::defenseBonus(Auth::user()->techs->fortification) }})<br/>
                                    @elseif ($key == 'replication')
                                        {{ GameInfo::replication($column) }} every {{ GameInfo::replicationFrequency() }} hours <br/>
                                    @endif
                                @endforeach
                            @else
                                @foreach ($table as $key => $column)
                                    @if ($key == 'turns')
                                        Their {{ $key }} are {{ $column }} <br/>
                                    @else
                                        Their {{ $key }} is {{ $column }} <br/>
                                    @endif
                                @endforeach
                            @endif


                        @endforeach
                    </p>
                </div>
            @elseif ($report->result == -1)
                <div class='battle'>
                    <p>
                        <span class='lost'>You lost</span>...<br/>
                    </p>

                    <p>
                        <b>{{ number_format($defenderDamage) }}</b> security was too much for your
                        <b>{{ number_format($attackerDamage) }}</b>
                        intelligence.<br/>
                    </p>

                    Prepare your spies better next time!<br/>
                </div>
            @else
                <div class='battle'>
                    <p>It's a draw!</p>
                    No Intel was gathered...
                    Prepare your spies better next time!<br/>
                </div>
            @endif
            <div class="text-center">
                <form action="{{ url('spy') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $defender->id }}">
                    <button class="btn btn-lg btn-danger m-10">Spy again!</button>
                    <div class="row">
                        <button class="btn btn-warning m-10" formaction="{{ url('battlefield') }}" formmethod="get">
                            Return to the Battlefield!
                        </button>
                        <button class="btn btn-primary" formaction="{{ url('dashboard/intelligence') }}" formmethod="get">
                            Train some spies or upgrade your Intelligence!
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop