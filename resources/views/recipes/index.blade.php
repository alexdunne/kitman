@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-xs-12">
                <ul>
                    @forelse($recipes as $recipe)
                        <li>
                            {{ $recipe->name }}
                        </li>
                    @empty
                        No recipes found.
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection
