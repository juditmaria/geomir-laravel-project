@if($post->likedByAuthUser())
<form method="POST" action="{{ route('posts.unlike', $post) }}" style="display: inline-block;">
    @csrf
    @method("DELETE")
    <button type="submit" class="btn btn-light">➖👍</button>
</form>
@else
<form method="POST" action="{{ route('posts.like', $post) }}" style="display: inline-block;">
    @csrf
    <button type="submit" class="btn btn-success">➕👍</button>
</form>
@endif