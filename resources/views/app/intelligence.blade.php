@extends('master')

@section('content')
    @include('errors.show')
    @include('success')
    <div class="card">
        <div class="card-header">
            <h2>{{ Auth::user()->name }}'s Covert Operations
                <small class="text-left">
                    <br>
                    <b>Spies</b> can give you info about your enemies fortifications.
                    <br>
                    <b>Intelligence</b> will enhance your spies.
                </small>
            </h2>
        </div>
        <div class="table-responsive" tabindex="1" style="outline: none;">
            <form action="{{ url('upgrade/intelligence') }}" method="post">
                {{ csrf_field() }}
                <table class="table">
                    <thead>

                    <tr>
                        <th colspan="3" class="h3">
                            Intelligence
                        </th>
                    </tr>
                    <tr>
                        <th>Current</th>
                        <th>Upgrade</th>
                        <th>Next</th>
                    </tr>

                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ Auth::user()->techs->intelligence }}
                            (x {{ GameInfo::intelligenceBonus(Auth::user()->techs->intelligence) }})
                        </td>
                        <td>
                            @if (GameInfo::costForNextIntelligence(Auth::user()))
                                <button class="btn btn-primary" type="submit">
                                    {{ GameInfo::costForNextIntelligence(Auth::user()) }}
                                </button>
                            @else
                                No more upgrades
                            @endif
                        </td>
                        <td>
                            @if (Auth::user()->techs->intelligence + 1 <= Config::get('constants.max_intelligence'))
                                {{ Auth::user()->techs->intelligence + 1 }}
                                (x {{ GameInfo::intelligenceBonus(Auth::user()->techs->intelligence + 1) }})
                            @else
                                Already at Max Intelligence
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </div>
        <div class="table-responsive" tabindex="1" style="overflow: hidden; outline: none;">
            <form id="train">
                {{ csrf_field() }}
                <table class="table">
                    <thead>
                    <tr>
                        <th colspan="4" class="text-center">Current Units</th>
                    </tr>
                    <tr>
                        <th class="text-center">Type</th>
                        <th class="text-center">Units</th>
                        <th class="text-center">Spy Rating</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Untrained</td>
                        <td>{{ Auth::user()->units->untrained }}</td>
                        <td>{{ GameInfo::spyForUnit('Untrained') * Auth::user()->units->untrained }}</td>
                    </tr>
                    <tr>
                        <td>Spies</td>
                        <td>{{ Auth::user()->units->spies }}</td>
                        <td>{{ GameInfo::spyForUnit('Spy') * Auth::user()->units->spies }}</td>
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
                        <td>Spies</td>
                        <td>{{GameInfo::costForUnit('Spy')}} / {{GameInfo::costForUnit('Untrain')}}</td>
                        <td>
                            <input type="number" class="form-control" name="spies" min="0">
                        </td>
                        <td>
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
                    </tbody>
                </table>
            </form>
        </div>

    </div>
@stop