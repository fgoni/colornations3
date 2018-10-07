@extends('master')
@section('styles')
    @parent
    <link href="vendors/bootgrid/jquery.bootgrid.min.css" rel="stylesheet">
@stop

@section('content')
    @include('errors.show')
    @include('success')
    <div class="card">
        <div class="card-header" @if(Auth::check()) id="{{Auth::user()->race_name}}" @endif>
            <h2 @if(Auth::check()) id="{{Auth::user()->race_name}}" @endif>Battlefield
                <small></small>
            </h2>
        </div>

        <div class="table-responsive">
            <table id="data-table-basic" class="table table-striped">
                <thead>
                <tr>
                    <th data-column-id="id" data-visible="false"></th>
                    <th data-column-id="overall_rank" data-type="numeric" data-align="center" data-order="asc">Ranking
                    </th>
                    <th data-column-id="username" data-formatter="href" data-sortable="false">Username</th>
                    <th data-column-id="tff" data-sortable="false">Fighting Force</th>
                    <th data-column-id="fortification" data-sortable="false">Fortification</th>
                    <th data-column-id="gold" data-sortable="false">Gold</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->overall_rank }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ GameInfo::unitsForUser($user) }}</td>
                        <td>{{ GameInfo::fortToString($user->techs->fortification) }}</td>
                        <td>@if (Auth::check() && (Gameinfo::intelligenceForUser(Auth::user()) > GameInfo::intelligenceForUser($user) || Auth::user()->id == $user->id))
                                {{ $user->resources->gold }}
                            @else
                                ???
                            @endif</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@stop

@section('scripts')
    @parent
    <script src="vendors/bootgrid/jquery.bootgrid.min.js"></script>
    <!-- Data Table -->
    <script type="text/javascript">
        $(document).ready(function () {
            //Basic Example
            $("#data-table-basic").bootgrid({
                css: {
                    icon: 'md icon',
                    iconColumns: 'md-view-module',
                    iconDown: 'md-expand-more',
                    iconRefresh: 'md-refresh',
                    iconUp: 'md-expand-less'
                },
                formatters: {
                    href: function (column, row) {
                        @if (Auth::check())
                        if ('{{ Auth::user()->id }}' == row.id)
                            return row.username;
                        @endif
                            return "<a href='{{ url('user/')}}/" + row.id + "'>" + row.username + "</a>";
                    }
                }
            });
        });
    </script>
@stop