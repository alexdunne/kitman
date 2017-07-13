@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <a href="{{ route('ingredients.edit', $ingredient->id) }}" class="btn btn-primary pull-right">
                    Edit ingredient
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-xs-12">
                {{ $ingredient->name }}
            </div>
        </div>
    </div>
@endsection
