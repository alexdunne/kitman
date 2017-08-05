@extends('layouts.app')

@section('content')
<<<<<<< 0b8b39ad84a931b924760d139d2094c4ca01a92c
    <recipe-form></recipe-form>
=======
    <recipe-form v-bind:ingredients="{{ $ingredients->toJson() }}"></recipe-form>
>>>>>>> Finished the rough version of the create recipe form
@endsection
