@extends('master')

@section('content')
    @include('errors.show')
    <div class="card">
        <div class="card-header">
            <p class="h2" style="color: #5E5E5E;">
                You attacked {{ $defender->name }}'s {{ GameInfo::fortToString($defender->techs->fortification) }}
            </p>
        </div>
        <div class="card-body card-padding">

            @if ($result == 'attacker')
                <div class='battle'>
                    <p>
                        <span class='won big'>You won</span> the battle!<br/>
                    </p>

                    <p>
                        Your attack of <b>{{ number_format($attackerDamage) }}</b> triumphed over
                        <b>{{ number_format($defenderDamage) }}</b> defense!<br/>
                    </p>

                    <p>
                        You won <span class="gold big">{{ number_format($stolen) }}</span> gold!<br/>
                        @if ($bankStolen > 0)
                            And an extra <span class="gold big">{{ number_format($bankStolen) }}</span> from their bank!<br/>
                        @endif
                        @if ($berserkerBonus > 0)
                            And an extra <span class="gold big">{{ number_format($berserkerBonus) }}</span> from your berserkers!<br/>
                        @endif
                        @if ($smallerBonus > 0)
                            And an extra <span class="gold big">{{ number_format($smallerBonus) }}</span> for having a smaller army!<br/>
                        @endif
                    </p>

                    <p>
                        @foreach (GameInfo::unitCombatColumns() as $column)
                            @if ( $injureds['attacker'][$column] > 0 )
                                {{ $injureds['attacker'][$column]}} {{ $column }} of your army died in battle!<br/>
                            @endif
                        @endforeach
                    </p>

                    <p>
                        @foreach (GameInfo::unitCombatColumns() as $column)
                            @if ( $injureds['defender'][$column] > 0 )
                                {{ $injureds['defender'][$column]}} {{ $column }} of your <b>ENEMY's</b> army died in
                                battle!
                                <br/>
                            @endif
                        @endforeach
                    </p>
                </div>
            @elseif ($result == 'defender')
                <div class='battle'>
                    <p>
                        <span class='lost'>You lost</span>...<br/>
                    </p>

                    <p>
                        <b>{{ number_format($defenderDamage) }}</b> defense was too much for your
                        <b>{{ number_format($attackerDamage) }}</b>
                        attack.<br/>
                    </p>

                    <p>
                        No gold was taken!<br/>
                    </p>

                    <p>
                        @foreach (GameInfo::unitCombatColumns() as $column)
                            @if ( $injureds['attacker'][$column] > 0 )
                                {{ $injureds['attacker'][$column]}} {{ $column }} of your army died in battle!<br/>
                            @endif
                        @endforeach
                    </p>

                    <p>
                        @foreach (GameInfo::unitCombatColumns() as $column)
                            @if ( $injureds['defender'][$column] > 0 )
                                {{ $injureds['defender'][$column]}} {{ $column }} of your ENEMY's army died in battle!
                                <br/>
                            @endif
                        @endforeach
                    </p>

                    Build a stronger army and keep trying!<br/>
                </div>
            @else
                <div class='battle'>
                    <p>It's a draw!</p>

                    <p>No gold was taken! {{--and $attacker_casualties of your men were injured.<br/>--}}</p>
                    {{--The enemy sustained $defender_casualties wounded soldiers.<br/>--}}
                    <p>Build a stronger army and keep trying!<br/></p>
                </div>
            @endif
            <div class="text-center">
                <form action="{{ url('attack') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $defender->id }}">
                    <button class="btn btn-lg btn-danger m-10">Attack again!</button>
                    <div class="row">
                        <button class="btn btn-primary" formaction="{{ url('dashboard/training') }}" formmethod="get">
                            Train some units!
                        </button>
                        <button class="btn btn-warning m-10" formaction="{{ url('battlefield') }}" formmethod="get">
                            Return to the Battlefield!
                        </button>
                        <button class="btn btn-primary" formaction="{{ url('dashboard/techs') }}" formmethod="get">Do
                            some upgrading!
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop