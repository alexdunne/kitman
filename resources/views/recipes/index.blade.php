@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-xs-12">
                <ul>
                    @foreach($recipes as $recipe)
                        <li>
                            {{ $recipe->name }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
