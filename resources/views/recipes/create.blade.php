@extends('layouts.app')

@section('content')
    <recipe-form v-bind:ingredients="{{ $ingredients->toJson() }}"></recipe-form>
@endsection
