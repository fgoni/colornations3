@extends('master')

@section('content')
    @include('errors.show')
    @include('success')
    <div class="card">
        <div class="card-header">
            <h2>{{ Auth::user()->name }}'s training camp
                <small class="text-left">
                    <br>
                    <b>Untrained</b> units are weak both for attacking and defending.
                    <br>
                    <b>Berserkers</b> have high Attack Strength but provide low Defense.
                    <br>
                    <b>Paladins</b> are better at defending than attacking.
                    <br>
                    <b>Merchants</b> provide no combat bonus but a big Income bonus
                </small>
            </h2>
        </div>
        <div class="table-responsive" tabindex="1" style="outline: none;">
            <form id="train">
                {{ csrf_field() }}
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th colspan="4" class="text-center">Current Units</th>
                    </tr>
                    <tr>
                        <th class="text-center">Type</th>
                        <th class="text-center">Units</th>
                        <th class="text-center">Attack Strength</th>
                        <th class="text-center">Defense Strength</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Untrained</td>
                        <td>{{ Auth::user()->units->untrained }}</td>
                        <td>{{ GameInfo::formatNum(GameInfo::attackForUser(Auth::user(), 'Untrained')) }}</td>
                        <td>{{ GameInfo::formatNum(GameInfo::defenseForUser(Auth::user(), 'Untrained')) }}</td>
                    </tr>
                    <tr>
                        <td>Berserkers</td>
                        <td>{{ Auth::user()->units->berserkers }}</td>
                        <td>{{ GameInfo::formatNum(GameInfo::attackForUser(Auth::user(), 'Berserker')) }}</td>
                        <td>{{ GameInfo::formatNum(GameInfo::defenseForUser(Auth::user(), 'Berserker')) }}</td>
                    </tr>
                    <tr>
                        <td>Paladins</td>
                        <td>{{ Auth::user()->units->paladins }}</td>
                        <td>{{ GameInfo::formatNum(GameInfo::attackForUser(Auth::user(), 'Paladin')) }}</td>
                        <td>{{ GameInfo::formatNum(GameInfo::defenseForUser(Auth::user(), 'Paladin')) }}</td>
                    </tr>
                    <tr>
                        <td>Archers</td>
                        <td>{{ Auth::user()->units->archers }}</td>
                        <td>{{ GameInfo::formatNum(GameInfo::attackForUser(Auth::user(), 'Archer')) }}</td>
                        <td>{{ GameInfo::formatNum(GameInfo::defenseForUser(Auth::user(), 'Archer')) }}</td>
                    </tr>
                    <tr>
                        <td>Saboteurs</td>
                        <td>{{ Auth::user()->units->saboteurs }}</td>
                        <td>{{ GameInfo::formatNum(GameInfo::attackForUser(Auth::user(), 'Saboteur')) }}</td>
                        <td>{{ GameInfo::formatNum(GameInfo::defenseForUser(Auth::user(), 'Saboteur')) }}</td>
                    </tr>
                    <tr>
                        <td>Merchants</td>
                        <td>{{ Auth::user()->units->merchants }}</td>
                        <td>{{ GameInfo::formatNum(GameInfo::attackForUser(Auth::user(), 'Merchant')) }}</td>
                        <td>{{ GameInfo::formatNum(GameInfo::defenseForUser(Auth::user(), 'Merchant')) }}</td>
                    </tr>
                    <tr>
                        <td>Injured</td>
                        <td>{{ Auth::user()->units->injured }}</td>
                        <td>{{ GameInfo::formatNum(GameInfo::attackForUser(Auth::user(), 'Injured')) }}</td>
                        <td>{{ GameInfo::formatNum(GameInfo::defenseForUser(Auth::user(), 'Injured')) }}</td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td>{{ GameInfo::formatNum(GameInfo::unitsForUser(Auth::user())) }}</td>
                        <td>{{ GameInfo::formatNum(GameInfo::attackForUser(Auth::user())) }}</td>
                        <td>{{ GameInfo::formatNum(GameInfo::defenseForUser(Auth::user())) }}</td>
                    </tr>
                    </tbody>
                    <thead>
                    <tr>
                        <th colspan="4" class="text-center">Train Units</th>
                    </tr>
                    <tr>
                        <th class="text-center">Type</th>
                        <th class="text-center">Cost</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Train</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Berserkers</td>
                        <td>{{GameInfo::costForUnit('Berserker')}} / {{GameInfo::costForUnit('Untrain')}}</td>
                        <td>
                            <input type="number" class="form-control" name="berserkers" min="0">
                        </td>
                        <td rowspan="3">
                            <button class="btn btn-primary" type="submit" form="train"
                                    formaction="{{ url('train') }}"
                                    formmethod="post">
                                Train
                            </button>
                            <button class="btn btn-info" type="submit" form="train"
                                    formaction="{{ url('untrain') }}" formmethod="post">
                                Untrain
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>Paladins</td>
                        <td>{{GameInfo::costForUnit('Paladin')}} / {{GameInfo::costForUnit('Untrain')}}</td>
                        <td>
                            <input type="number" class="form-control" name="paladins" min="0">
                        </td>
                    </tr>
                    <tr>
                        <td>Archers</td>
                        <td>{{GameInfo::costForUnit('Archer')}} / {{GameInfo::costForUnit('Untrain')}}</td>
                        <td>
                            <input type="number" class="form-control" name="archers" min="0">
                        </td>
                    </tr>
                    <tr>
                        <td>Saboteurs</td>
                        <td>{{GameInfo::costForUnit('Saboteur')}} / {{GameInfo::costForUnit('Untrain')}}</td>
                        <td>
                            <input type="number" class="form-control" name="saboteurs" min="0">
                        </td>
                    </tr>
                    <tr>
                        <td>Merchants</td>
                        <td>{{GameInfo::costForUnit('Merchant')}} / {{GameInfo::costForUnit('Untrain')}}</td>
                        <td>
                            <input type="number" class="form-control" name="merchants" min="0">
                        </td>
                    </tr>
                    </tbody>
                    <thead>
                    <tr>
                        <th colspan="4" class="text-center">Heal Injured</th>
                    </tr>
                    <tr>
                        <th class="text-center">Type</th>
                        <th class="text-center">Cost</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Heal</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="text-center">{{ Auth::user()->units->injured }}</td>
                        <td class="text-center">{{ GameInfo::costForUnit('Injured') }}</td>
                        <td>
                            <input type="number" class="form-control" name="injured" min="0">
                        </td>
                        <td>
                            <button class="btn btn-primary" type="submit" form="train"
                                    formaction="{{ url('train/injured') }}"
                                    formmethod="post">
                                Heal
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
@stop