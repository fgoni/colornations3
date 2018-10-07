@extends('master')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>{{ Auth::user()->name }}'s headquarters
                <small>Check out all your stats here</small>
            </h2>
        </div>

        <div class="table-responsive" tabindex="1" style="outline: none;">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Technology</th>
                    <th>Current level</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Siege</td>
                    <td>{{ GameInfo::siegeToString(Auth::user()->techs->siege) }}
                        (x{{ GameInfo::attackBonus(Auth::user()->techs->siege) }})
                    </td>
                </tr>
                <tr>
                    <td>Fortification</td>
                    <td>{{ GameInfo::fortToString(Auth::user()->techs->fortification) }}
                        (x{{ GameInfo::attackBonus(Auth::user()->techs->fortification) }})
                    </td>
                </tr>
                <tr>
                    <td>Intelligence Level</td>
                    <td>{{ Auth::user()->techs->intelligence }}</td>
                </tr>
                <tr>
                    <td>Unit Replication</td>
                    <td>{{ Auth::user()->techs->replication }}</td>
                </tr>
                <tr>
                    <td>Army</td>
                    <td>{{ GameInfo::formatNum(GameInfo::unitsForUser(Auth::user()) )}} fighting units</td>
                </tr>
                <tr>
                    <td>Treasure</td>
                    <td>{{ GameInfo::formatNum(Auth::user()->resources->gold) }} gold</td>
                </tr>
                <tr>
                    <td>Income</td>
                    <td>{{ GameInfo::formatNum(GameInfo::incomeForUser(Auth::user())) }} gold per turn</td>
                </tr>
                <tr>
                    <td>Attack</td>
                    <td>{{ GameInfo::formatNum(GameInfo::attackForUser(Auth::user())) }}</td>
                </tr>
                <tr>
                    <td>Defense</td>
                    <td>{{ GameInfo::formatNum(GameInfo::defenseForUser(Auth::user())) }}</td>
                </tr>
                <tr>
                    <td>Intelligence</td>
                    <td>{{ GameInfo::formatNum(GameInfo::intelligenceForUser(Auth::user())) }}</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="table-responsive" tabindex="1" style="outline: none;">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Type</th>
                    <th>Units</th>
                    <th>Attack Strength</th>
                    <th>Defense Strength</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Untrained</td>
                    <td>{{Auth::user()->units->untrained }}</td>
                    <td>{{GameInfo::formatNum(GameInfo::attackForUser(Auth::user(), 'Untrained'))}}</td>
                    <td>{{GameInfo::formatNum(GameInfo::defenseForUser(Auth::user(), 'Untrained'))}}</td>
                </tr>
                <tr>
                    <td>Berserker</td>
                    <td>{{Auth::user()->units->berserkers }}</td>
                    <td>{{GameInfo::formatNum(GameInfo::attackForUser(Auth::user(), 'Berserker'))}}</td>
                    <td>{{GameInfo::formatNum(GameInfo::defenseForUser(Auth::user(), 'Berserker'))}}</td>
                </tr>
                <tr>
                    <td>Paladin</td>
                    <td>{{Auth::user()->units->paladins }}</td>
                    <td>{{GameInfo::formatNum(GameInfo::attackForUser(Auth::user(), 'Paladin'))}}</td>
                    <td>{{GameInfo::formatNum(GameInfo::defenseForUser(Auth::user(), 'Paladin'))}}</td>
                </tr>
                <tr>
                    <td>Archer</td>
                    <td>{{Auth::user()->units->archers }}</td>
                    <td>{{GameInfo::formatNum(GameInfo::attackForUser(Auth::user(), 'Archer'))}}</td>
                    <td>{{GameInfo::formatNum(GameInfo::defenseForUser(Auth::user(), 'Archer'))}}</td>
                </tr>
                <tr>
                    <td>Saboteur</td>
                    <td>{{Auth::user()->units->saboteurs }}</td>
                    <td>{{GameInfo::formatNum(GameInfo::attackForUser(Auth::user(), 'Saboteur'))}}</td>
                    <td>{{GameInfo::formatNum(GameInfo::defenseForUser(Auth::user(), 'Saboteur'))}}</td>
                </tr>
                <tr>
                </tbody>
            </table>
        </div>
    </div>
@stop