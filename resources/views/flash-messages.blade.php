@foreach(['danger', 'warning', 'success', 'info'] as $message   )
    @if(Session::has($message))
        dd($mesage);
        <p class="alert alert-{{ $message }}">
            Session:get($message)
        </p>
    @endif
@endforeach