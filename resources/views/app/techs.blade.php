@extends('master')

@section('content')
    @include('errors.show')
    @include('success')
    <div class="card">
        <div class="card-header">
            <h2>{{ Auth::user()->name }}'s technologies
                <small>Upgrade your technologies here.</small>
            </h2>
        </div>
        <div class="table-responsive" tabindex="1" style="outline: none;">
            <form id="upgrades">
                {{ csrf_field() }}
                <table class="table">
                    <thead>
                    <tr>
                        <th colspan="3" class="text-center">Siege Technology</th>
                    </tr>
                    <tr>
                        <th class="text-center">Current</th>
                        <th class="text-center">Upgrade</th>
                        <th class="text-center">Next</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="text-center">{{ GameInfo::siegeToString(Auth::user()->techs->siege) }}
                            (x{{ GameInfo::attackBonus(Auth::user()->techs->siege) }})
                        </td>
                        <td class="text-center">
                            @if (GameInfo::costForNextSiege(Auth::user()->techs->siege))
                                <button class="btn btn-primary" type="submit" form="upgrades"
                                        formaction="{{ url('upgrade/siege') }}"
                                        formmethod="post">
                                    {{ GameInfo::costForNextSiege(Auth::user()->techs->siege) }}
                                </button>
                            @else
                                No more upgrades
                            @endif
                        </td>
                        <td class="text-center">
                            @if (GameInfo::nextSiegeToString(Auth::user()->techs->siege))
                                {{ GameInfo::nextSiegeToString(Auth::user()->techs->siege) }}
                                (x{{ GameInfo::attackBonus(Auth::user()->techs->siege+1) }})
                            @else
                                Already at Max Siege
                            @endif
                        </td>
                    </tr>
                    </tbody>
                    <thead>
                    <tr>
                        <th colspan="3" class="text-center">Fort Technology</th>
                    </tr>
                    <tr>
                        <th class="text-center">Current</th>
                        <th class="text-center">Upgrade</th>
                        <th class="text-center">Next</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="text-center">{{ GameInfo::fortToString(Auth::user()->techs->fortification) }}
                            (x{{ GameInfo::attackBonus(Auth::user()->techs->fortification)}})
                        </td>
                        <td class="text-center">
                            @if (GameInfo::costForNextFort(Auth::user()->techs->fortification))
                                <button class="btn btn-primary" type="submit" form="upgrades"
                                        formaction="{{ url('upgrade/fort') }}"
                                        formmethod="post">
                                    {{ GameInfo::costForNextFort(Auth::user()->techs->fortification) }}
                                </button>
                            @else
                                No more upgrades
                            @endif
                        </td>
                        <td class="text-center">
                            @if (GameInfo::nextFortToString(Auth::user()->techs->fortification))
                                {{ GameInfo::nextFortToString(Auth::user()->techs->fortification) }}
                                (x{{ GameInfo::attackBonus(Auth::user()->techs->fortification+1)}})
                            @else
                                Already at Max Fortification
                            @endif
                        </td>
                    </tr>
                    </tbody>
                    <thead>
                    <tr>
                        <th colspan="3" class="text-center">Replication Technology</th>
                    </tr>
                    <tr>
                        <th class="text-center">Current</th>
                        <th class="text-center">Upgrade</th>
                        <th class="text-center">Next</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="text-center">{{ GameInfo::replication((Auth::user()->techs->replication)) }}</td>
                        <td class="text-center">
                            @if (GameInfo::costForNextReplication(Auth::user()->techs->replication))
                                <button class="btn btn-primary" type="submit" form="upgrades"
                                        formaction="{{ url('upgrade/replication') }}"
                                        formmethod="post">
                                    {{ GameInfo::costForNextReplication(Auth::user()->techs->replication) }}
                                </button>
                            @else
                                No more upgrades
                            @endif
                        </td>
                        <td class="text-center">{{ GameInfo::nextReplication(Auth::user()->techs->replication) }}</td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
@stop