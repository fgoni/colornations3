@if (count($errors) > 0)
    <div class="alert alert-danger">
        @if (count($errors) > 1)
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @else
            {{ $errors->first() }}
        @endif
    </div>
@endif