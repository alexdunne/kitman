@extends('layouts.app')

@section('content')
    <ul>
        @forelse($recipes as $recipe)
            <li>
                <a href="{{ route('recipes.show', ['id' => $recipe->id]) }}">
                    {{ $recipe->name }}
                </a>
            </li>
        @empty
            No recipes found.
        @endforelse
    </ul>
@endsection
