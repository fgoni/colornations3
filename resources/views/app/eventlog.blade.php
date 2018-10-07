@extends('master')

@section('content')
    <div class="card">
        @include('errors.show')
        @include('success')
        <div class="card-header">
            <h2>Game Event history
                <small>
                    <p>See which events occurred and when</p>
                </small>
            </h2>
        </div>
        <div class="card-body card-padding">
            <div class="row p-10">
                <div class="col-lg-6 col-xs-12">
                    <h4>Event</h4>
                </div>
                <div class="col-lg-3 col-xs-12">
                    <h4>Started at</h4>
                </div>
                <div class="col-lg-3 col-xs-12">
                    <h4>Finished at</h4>
                </div>
            </div>
            @foreach ($eventLogs as $eventLog)
                <div class="row p-10">
                    <div class="col-lg-6 col-xs-12">
                        {{  $eventLog->event->name }}
                        <br/>
                        <small>{{ $eventLog->event->description }}</small>
                    </div>
                    <div class="col-lg-3 col-xs-12">
                        {{ $eventLog->started_at}}
                    </div>
                    <div class="col-lg-3 col-xs-12">
                        @if ($eventLog->finished_at->gt($eventLog->started_at))
                            {{ $eventLog->finished_at }}
                        @else
                            Not finished yet
                        @endif
                    </div>
                </div>
            @endforeach
            {!! $eventLogs->render() !!}
        </div>
    </div>
@stop

