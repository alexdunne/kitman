@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-xs-12">
                <ul>
                    @forelse($ingredients as $ingredient)
                        <li>
                            {{ $ingredient->name }}
                        </li>
                    @empty
                        No ingredients found.
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection
