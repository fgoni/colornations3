@extends('master')

@section('content')
    @include('errors.show')
    @include('success')
    <div class="card">
        <div class="card-header">
            <h2>{{ Auth::user()->name }}'s personal bank
                <small>
                    <p>You can deposit your gold in the bank at a 80% ratio.</p>

                    <p>You can withdraw all you want in any way at any time, as long as you have it deposited</p>
                </small>
            </h2>
        </div>
        <div class="table-responsive" tabindex="1" style="outline: none;">
            <table class="table" id="economy">
                <thead>
                <tr>
                    <th colspan="4" class="text-center">Bank</th>
                </tr>
                </thead>
                <tbody>
                <form method="post" action="{{ url('deposit') }}">
                    {!! csrf_field() !!}
                    <tr>
                        <td class="text-center">Deposit</td>
                        <td class="text-center">
                            <input type="number" name="deposit" step="1" min="0"
                                   value="{{ Auth::user()->resources->gold }}" v-model="deposit" number>
                        </td>
                        <td class="text-center">
                            @{{ currentGold - deposit}}
                        </td>
                        <td class="text-center">
                            <button class="btn btn-primary" type="submit">Deposit</button>
                        </td>
                    </tr>
                </form>
                <form method="post" action="{{ url('withdraw') }}">
                    {!! csrf_field() !!}
                    <tr>

                        <td class="text-center">Withdraw</td>
                        <td class="text-center">
                            <input type="number" name="withdraw" step="1" min="0" value="{{ $balance }}"
                                   v-model="withdraw" number>
                        </td>
                        <td class="text-center">
                            @{{ currentGold + withdraw}}
                        </td>
                        <td class="text-center">
                            <button class="btn btn-primary" type="submit">Withdraw</button>
                        </td>
                    </tr>
                </form>
                <form action="{{ url('upgrade/autobanking') }}" method="post">
                    {{ csrf_field() }}
                    <tr>
                        <th colspan="4" class="text-center">Current Balance</th>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-center">
                            {{ $balance }}
                        </td>
                    </tr>
                    <tr>
                        <th colspan="4" class="text-center">Autobanking</th>
                    </tr>
                    <tr>
                        <th>Current</th>
                        <th colspan="2">Upgrade to Next</th>
                        <th>Next</th>
                    </tr>
                    <tr>
                        <td class="text-center">
                            {{ GameInfo::autobanking(Auth::user()) }}%
                        </td>
                        <td colspan="2" class="text-center">
                            @if (GameInfo::costForNextAutobanking(Auth::user()->balance->autobanking))
                                <button class="btn btn-primary" type="submit">
                                    {{ GameInfo::costForNextAutobanking(Auth::user()->balance->autobanking) }}
                                </button>
                            @else
                                No more upgrades
                            @endif
                        </td>
                        <td>
                            @if (GameInfo::autoBanking(Auth::user(), true))
                                {{ GameInfo::nextAutobanking(Auth::user()) }}%
                            @else
                                Already at Max Autobanking
                            @endif
                        </td>
                    </tr>
                </form>
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('scripts')
    @parent
    <script>
        new Vue({
            el: '#economy',
            data: {
                currentGold: parseInt("{{ Auth::user()->resources->gold }}")
            }
        })
    </script>
@stop