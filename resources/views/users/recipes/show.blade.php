@if (count($recipes))
    <ul>
        @foreach ($recipes as $recipe)
            <li>{{ $recipe->name }}</li>
        @endforeach
    </ul>
@else
    No recipes found.
@endif