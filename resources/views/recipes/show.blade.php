@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-xs-12">
                <h1>{{ $recipe->name }}</h1>

                <section>
                    <header>Ingredients</header>
                    <ul>
                        @forelse($recipe->recipeIngredients as $recipeIngredient)
                            <li>
                                {{ $recipeIngredient->ingredient->name }}:
                                {{ $recipeIngredient->quantity }}
                                {{ $recipeIngredient->unitOfMeasurement }}
                            </li>
                        @empty
                            No recipes found.
                        @endforelse
                    </ul>
                </section>

                <section>
                    <header>Instructions</header>
                    <ul>
                        @forelse($recipe->instructions as $instruction)
                            <li>
                                {{ $instruction->description }}
                            </li>
                        @empty
                            No recipes found.
                        @endforelse
                    </ul>
                </section>
            </div>
        </div>
    </div>
@endsection
