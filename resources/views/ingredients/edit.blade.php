@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-xs-12">
                @include('errors')

                <form method="post" action="/ingredients/{{ $ingredient->id }}">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <div class="form-group">
                        <label for="ingredient-name">Name</label>
                        <input id="ingredient-name" type="text" name="name"
                               class="form-control" placeholder="Enter a name for the ingredient"
                               value="{{ $ingredient->name }}"
                        />
                    </div>

                    <button type="submit" class="btn btn-default">Save</button>
                </form>
            </div>
        </div>
    </div>
@endsection