<ul>
  @foreach ($user->recipes as $recipe)
    <li>{{ $recipe->name }}</li>
  @endforeach
</ul>