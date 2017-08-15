@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 col-xs-12">
                <h1>{{ $recipe->name }}</h1>

                @if(count($recipe->recipeIngredients))
                    <section>
                        <header>Ingredients</header>
                        <ul>
                            @foreach($recipe->recipeIngredients as $recipeIngredient)
                                <li>
                                    {{ $recipeIngredient->ingredient->name }}:
                                    {{ $recipeIngredient->quantity }}
                                    {{ $recipeIngredient->unitOfMeasurement }}
                                </li>
                            @endforeach
                        </ul>
                    </section>
                @endif

                @if(count($recipe->instructions))
                    <section>
                        <header>Instructions</header>
                        <ul>
                            @foreach($recipe->getOrderedInstructions() as $instruction)
                                <li>
                                    {{ $instruction->description }}
                                </li>
                            @endforeach
                        </ul>
                    </section>
                @endif
            </div>
        </div>
    </div>
@endsection
