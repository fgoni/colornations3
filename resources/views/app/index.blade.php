@extends('master')

@section('content')
    <div class="card text-center">
        <div class="card-header">
            <h1>Welcome to Color Nations!</h1>
        </div>
        <div class="card-body card-padding">
            <h3>Choose from 4 races with different bonuses!</h3>

            <div class="row p-t-30 p-b-30">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header bgm-red">
                            <h2>Reds</h2>
                        </div>
                        <div class="card-body card-padding">
                            <b>Aggresive Faction</b><br>
                            30% Attack Bonus<br>
                            10% Extra gold on attacks
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header bgm-blue">
                            <h2>Blues</h2>
                        </div>
                        <div class="card-body card-padding">
                            <b>Defensive Faction</b><br>
                            30% Defense Bonus<br>
                            10% Extra Autobanking
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header bgm-green">
                            <h2>Greens</h2>
                        </div>
                        <div class="card-body card-padding">
                            <b>Balanced Faction</b><br>
                            30% Income Bonus
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header bgm-orange">
                            <h2>Oranges</h2>
                        </div>
                        <div class="card-body card-padding">
                            <b>Balanced Faction</b><br>
                            15% Tech Price Bonus
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-md-offset-4 ">
                    <div class="col-md-12 m-b-10">
                        <a href="{{ url('auth/register') }}" class="btn btn-primary btn-block">
                            Start playing NOW!
                        </a>
                    </div>
                    OR
                    <div class="col-md-12 m-t-10">
                        <a href="{{ url('auth/login') }}" class="btn btn-primary btn-block">
                            Login with your existing account!
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9">

                    <div class="card">
                        <div class="card-header bgm-gray">
                            <h2>Latest Changes</h2>
                        </div>
                        <div class="card-body card-padding text-left">
                            <h3>Season 3!</h3>
                            <ul class="clist clist-angle">
                                <li>Injured cost: 500 -> 200</li>
                                <li>Merchants Income: 5->8</li>
                                <li>Greens Bonus: 20% -> 30%</li>
                                <li>Oranges Bonus: 20% -> 15%</li>
                                <li>Blue Bonus: Also gives 10% extra Autobanking</li>
                                <li>Red Bonus: Also gives 10% extra gold on successful attacks.</li>
                                <li>Autobanking Upgrades: 1% -> 5% (max 50%) Bigger cost.</li>
                                <li>Bonus Gold for defeating a bigger opponent up to 25% based on army size difference (smaller armies should depend
                                    on attacks)
                                </li>
                                <li>Less loot for defeating a smaller opponent, up to 25% based on army size difference (bigger armies should depend
                                    on income)
                                </li>
                                <li>Some Events rebalanced:</li>
                                <li>Drums of War: Berserkers have 50% more attack and steal 50% more gold</li>
                                <li>Swiss Time: Every 5 minutes, Merchants generate income and bank it.</li>
                                <li>The Black Death has 50% chance of affecting you, from 100%.</li>
                                <li>Fixed Flaming Arrows bug (gave WAY more attack than expected)</li>
                                <li>Tithe: Paladins give twice their income every 5 minutes.</li>
                                <li>Gold Rush: Every 5 minutes, a random player gets a ton of gold.</li>
                                <li>Tech Bonus now scales a bit less, making last upgrades not as strong: 25% -> 20% / Max x35.51 > x18.56)</li>
                            </ul>
                            <h3>Season 2!</h3>
                            <ul class="clist clist-angle">
                                <li>Two new units, that scale with your technologies: Archers (defensive) and Saboteurs
                                    (offensive)
                                </li>
                                <li>Untrained now have 2/2 combat stats, Berserkers 8/4, Paladins 4/8</li>
                                <li>Two new Fortifications: Boiling Oil and Castle</li>
                                <li>Fortification Bonus reduced from 28% to 25%</li>
                                <li>Attacks now cost 4 turns, and you get 1 turn every 30 minutes</li>
                                <li>Bank now shows you your current Autobanking, and you can upgrade it</li>
                                <li>Income from Units halved</li>
                                <li>Unit replication now occurs every 6 hours, but at half the rate</li>
                                <li>Units get injured after fighting, but you can heal them back to Untrained status for
                                    a hefty price
                                </li>
                            </ul>
                            <h4>11/12/2015</h4>
                            <ul class="clist clist-angle">
                                <li>You can now Race Change on the Settings page</li>
                                <li>Quality of Life improvements for Economy page</li>
                                <li>Total Units, Attack and Defense on Training section</li>
                            </ul>
                            <h4>10/12/2015</h4>
                            <ul class="clist clist-angle">
                                <li>Turns capped at 200</li>
                                <li>Turns give out from 4 to 3 every 30 minutes</li>
                                <li>Gold can be deposited in the Bank at any number</li>
                                <li>Better "After Battle" navigation.</li>
                            </ul>
                            <h4>04/12/2015</h4>
                            <ul class="clist clist-angle">
                                <li>Income is now autobanked at a rate of {{GameInfo::autoBanking() }}%</li>
                                <li>Better CombatLog UI for Mobile</li>
                                <li>Settings now in the Main Menu Bar</li>
                                <li>You can't attack yourself anymore</li>
                            </ul>
                            <h4>Season 1</h4>
                            <ul class="clist clist-angle">
                                <li>Gold stolen is now between 80-100% of total gold instead of always 100%</li>
                                <li>Damage calculation now has a random factor (90-110%) to spice up close battles</li>
                                <li>To attack another player, you need Turns.
                                    <ol type="1">
                                        <li>You start the game with {{GameInfo::startingTurns()}} turns.</li>
                                        <li>Every half hour you get {{ GameInfo::turnsForUser() }} turns.</li>
                                        <li>You need 1 turn to attack.</li>
                                    </ol>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">

                    <div class="card">
                        <div class="card-header bgm-gray">
                            <h2>Top Players</h2>
                        </div>
                        <div class="card-body card-padding">
                            <ul class="clist clist-angle text-left">
                                @foreach($topPlayers as $key => $topPlayer)
                                    <li>{{  $key+1 }} - {{ $topPlayer->name }} </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bgm-gray">
                            <h2>Last Season Top Players</h2>
                        </div>
                        <div class="card-body card-padding">
                            <ul class="clist clist-angle text-left">
                                @foreach($lastSeasonTopPlayers as $key => $topPlayer)
                                    <li>
                                        @if ($topPlayer != null){{  $key+1 }} - {{ $topPlayer->name }}
                                        @else {{ $key + 1 }} - <span style="color:#d62728">Left</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@stop
