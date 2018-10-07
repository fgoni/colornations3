@extends('master')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>Game Info
                <small>
                </small>
            </h2>
        </div>
        <div class="table-responsive" tabindex="1" style="outline: none;">
            <table class="table">
                <thead>
                <tr>
                    <th colspan="2" class="text-center">Account Features</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="text-center">Race Changes</td>
                    <td class="text-center">{{GameInfo::raceChanges()}}</td>
                </tr>
                </tbody>

                <thead>
                <tr>
                    <th colspan="2" class="text-center">Frequencies</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="text-center">Replication Frequency</td>
                    <td class="text-center">{{GameInfo::replicationFrequency()}} hours</td>
                </tr>
                <tr>
                    <td class="text-center">Income Frequency</td>
                    <td class="text-center">{{GameInfo::incomeFrequency()}} minutes</td>
                </tr>
                <tr>
                    <td class="text-center">Ranking Update Frequency</td>
                    <td class="text-center">{{GameInfo::incomeFrequency()}} minutes</td>
                </tr>
                <tr>
                    <td class="text-center">Turns Frequency</td>
                    <td class="text-center">{{GameInfo::incomeFrequency()}} minutes</td>
                </tr>
                </tbody>

                <thead>
                <tr>
                    <th colspan="2" class="text-center">Combat Technologies</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Siege Modifier</td>
                    <td>{{GameInfo::siegeModifier()}}</td>
                <tr>
                <tr>
                    <td>Fortification Modifier</td>
                    <td>{{GameInfo::fortModifier()}}</td>
                </tr>
                </tbody>
            </table>
            <table class="table">
                <thead>
                <tr>
                    <th colspan="4" class="text-center">Unit Stats</th>
                </tr>
                <tr>
                    <th>Types</th>
                    <th>Attack Strength</th>
                    <th>Defense Strength</th>
                    <th>Income</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Untrained</td>
                    <td>{{GameInfo::attackForUnit('Untrained')}}</td>
                    <td>{{GameInfo::defenseForUnit('Untrained')}}</td>
                    <td>{{GameInfo::incomeForUnit('Untrained')}}</td>
                <tr>
                <tr>
                    <td>Berserker</td>
                    <td>{{GameInfo::attackForUnit('Berserker')}}</td>
                    <td>{{GameInfo::defenseForUnit('Berserker')}}</td>
                    <td>{{GameInfo::incomeForUnit('Berserker')}}</td>
                <tr>
                <tr>
                    <td>Paladin</td>
                    <td>{{GameInfo::attackForUnit('Paladin')}}</td>
                    <td>{{GameInfo::defenseForUnit('Paladin')}}</td>
                    <td>{{GameInfo::incomeForUnit('Paladin')}}</td>
                <tr>
                <tr>
                    <td>Archer</td>
                    <td>{{GameInfo::attackForUnit('Archer')}}</td>
                    <td>{{GameInfo::defenseForUnit('Archer')}}</td>
                    <td>{{GameInfo::incomeForUnit('Archer')}}</td>
                <tr>
                <tr>
                    <td>Saboteur</td>
                    <td>{{GameInfo::attackForUnit('Saboteur')}}</td>
                    <td>{{GameInfo::defenseForUnit('Saboteur')}}</td>
                    <td>{{GameInfo::incomeForUnit('Saboteur')}}</td>
                <tr>
                <tr>
                    <td>Merchant</td>
                    <td>{{GameInfo::attackForUnit('Merchant')}}</td>
                    <td>{{GameInfo::defenseForUnit('Merchant')}}</td>
                    <td>{{GameInfo::incomeForUnit('Merchant')}}</td>
                <tr>
                <tr>
                    <td>Injured</td>
                    <td>{{GameInfo::attackForUnit('Injured')}}</td>
                    <td>{{GameInfo::defenseForUnit('Injured')}}</td>
                    <td>{{GameInfo::incomeForUnit('Injured')}}</td>
                <tr>
                </tbody>
            </table>
        </div>
    </div>
@stop