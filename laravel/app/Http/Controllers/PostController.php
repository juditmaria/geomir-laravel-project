<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\File;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::withCount('likes')->get();

        return view("posts.index", [
            "posts" => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        return view("posts.create");  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validar dades del formulari
        $validatedData = $request->validate([
            'body'       => 'required',
            'upload'     => 'required|mimes:gif,jpeg,jpg,png,mp4|max:2048',
            'latitude'   => 'required',
            'longitude'  => 'required',
            'visibility' => 'required|exists:visibilities,id',
        ]);
        
        // Obtenir dades del formulari
        $body          = $request->get('body');
        $upload        = $request->file('upload');
        $latitude      = $request->get('latitude');
        $longitude     = $request->get('longitude');
        $visibility  = $request->get('visibility');

        // Desar fitxer al disc i inserir dades a BD
        $file = new File();
        $fileOk = $file->diskSave($upload);

        if ($fileOk) {
            // Desar dades a BD
            Log::debug("Saving post at DB...");
            $post = Post::create([
                'body'          => $body,
                'file_id'       => $file->id,
                'latitude'      => $latitude,
                'longitude'     => $longitude,
                'visibility_id' => $visibility,
                'author_id'     => auth()->user()->id,
            ]);
            Log::debug("DB storage OK");
            // Patró PRG amb missatge d'èxit
            return redirect()->route('posts.show', $post)
                ->with('success', __(':resource successfully saved', [
                    'resource' => __('resources.post')
                ]));
        } else {
            // Patró PRG amb missatge d'error
            return redirect()->route("posts.create")
                ->with('error', __('ERROR Uploading file'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        // Likes counter
        $post->loadCount('likes');
        
        return view("posts.show", [
            'post'  => $post,
            'file'   => $post->file,
            'author' => $post->user,
            'numLikes' => $post->likes_count,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        // Comprovar si l'usuari/a pot editar (PostPolicy)
        $this->authorize('update', $post);

        return view("posts.edit", [
            'post'   => $post,
            'file'   => $post->file,
            'author' => $post->user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        // Comprovar si l'usuari/a pot editar (PostPolicy)
        $this->authorize('update', $post);

        // Validar dades del formulari
        $validatedData = $request->validate([
            'body'       => 'required',
            'upload'     => 'nullable|mimes:gif,jpeg,jpg,png,mp4|max:2048',
            'latitude'   => 'required',
            'longitude'  => 'required',
            'visibility' => 'required|exists:visibilities,id',
        ]);

        // Obtenir dades del formulari
        $body      = $request->get('body');
        $upload    = $request->file('upload');
        $latitude  = $request->get('latitude');
        $longitude = $request->get('longitude');
        $visibility  = $request->get('visibility');

        // Desar fitxer (opcional)
        if (is_null($upload) || $post->file->diskSave($upload)) {
            // Actualitzar dades a BD
            Log::debug("Updating DB...");
            $post->body           = $body;
            $post->latitude       = $latitude;
            $post->longitude      = $longitude;
            $post->visibility_id = $visibility;
            $post->save();
            Log::debug("DB storage OK");
            // Patró PRG amb missatge d'èxit
            return redirect()->route('posts.show', $post)
                ->with('success', __(':resource successfully updated', [
                    'resource' => __('resources.post')
                ]));
        } else {
            // Patró PRG amb missatge d'error
            return redirect()->route("posts.edit")
                ->with('error', __('ERROR Uploading file'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        // Comprovar si l'usuari/a pot eliminar (PostPolicy)
        $this->authorize('delete', $post);

        // Eliminar post de BD
        $post->delete();

        // Eliminar fitxer associat del disc i BD
        $post->file->diskDelete();
        
        // Patró PRG amb missatge d'èxit
        return redirect()->route("posts.index")
            ->with('success', __(':resource successfully deleted', [
                'resource' => __('resources.post')
            ]));
    }

    /**
     * Add like
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function like(Post $post) 
    {
        $like = Like::create([
            'user_id'  => auth()->user()->id,
            'post_id' => $post->id
        ]);

        return redirect()->back()
            ->with('success', __(':resource successfully saved', [
                'resource' => __('resources.like')
            ]));
    }

    /**
     * Undo like
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function unlike(Post $post) 
    {
        $like = Like::where([
            ['user_id', '=', auth()->user()->id],
            ['post_id', '=', $post->id],
        ])->first();
        
        $like->delete();

        return redirect()->back()
            ->with('success', __(':resource successfully deleted', [
                'resource' => __('resources.like')
            ]));
    }
}
