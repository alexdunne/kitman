@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-xs-12">
                {{ $ingredient->name }}
            </div>
        </div>
    </div>
@endsection
