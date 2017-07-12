@foreach(['danger', 'warning', 'success', 'info'] as $message)
    @if(Session::has($message))
        <p class="alert alert-{{ $message }}">
            {{ Session::get($message) }}
        </p>
    @endif
@endforeach