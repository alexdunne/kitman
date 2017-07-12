@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <a href="{{ route('ingredients.create') }}" class="btn btn-primary pull-right">Add new</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-xs-12">
                <ul>
                    @forelse($ingredients as $ingredient)
                        <li>
                            <a href="{{ route('ingredients.show', $ingredient->id) }}">
                                {{ $ingredient->name }}
                            </a>
                        </li>
                    @empty
                        No ingredients found.
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection
