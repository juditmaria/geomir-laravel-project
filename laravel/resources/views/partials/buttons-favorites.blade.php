@if($place->favoritedByAuthUser())
<form method="POST" action="{{ route('places.unfavorite', $place) }}" style="display: inline-block;">
    @csrf
    @method("DELETE")
    <button type="submit" class="btn btn-light">➖❤️</button>
</form>
@else
<form method="POST" action="{{ route('places.favorite', $place) }}" style="display: inline-block;">
    @csrf
    <button type="submit" class="btn btn-success">➕❤️</button>
</form>
@endif