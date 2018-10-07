@if(Session::has('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        @if (is_array(Session::get('success')) && count(Session::get('success')) > 0)
            @foreach(Session::get('success') as $success)
                {{ $success }} @if ($success != last(Session::get('success'))) <br/> @endif
            @endforeach
        @else
            {{ Session::get('success') }}
        @endif
    </div>
@endif