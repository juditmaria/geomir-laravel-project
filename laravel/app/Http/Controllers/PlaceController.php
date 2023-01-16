<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\File;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $places = Place::withCount('favorites')->get();

        return view("places.index", [
            "places" => $places
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("places.create");
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
            'name'        => 'required',
            'description' => 'required',
            'upload'      => 'required|mimes:gif,jpeg,jpg,png,mp4|max:2048',
            'latitude'    => 'required',
            'longitude'   => 'required',
            'visibility'  => 'required|exists:visibilities,id',
        ]);
        
        // Obtenir dades del formulari
        $name        = $request->get('name');
        $description = $request->get('description');
        $upload      = $request->file('upload');
        $latitude    = $request->get('latitude');
        $longitude   = $request->get('longitude');
        $visibility  = $request->get('visibility');

        // Desar fitxer al disc i inserir dades a BD
        $file = new File();
        $fileOk = $file->diskSave($upload);

        if ($fileOk) {
            // Desar dades a BD
            Log::debug("Saving place at DB...");
            $place = Place::create([
                'name'          => $name,
                'description'   => $description,
                'file_id'       => $file->id,
                'latitude'      => $latitude,
                'longitude'     => $longitude,
                'visibility_id' => $visibility,
                'author_id'     => auth()->user()->id,
            ]);
            \Log::debug("DB storage OK");
            // Patró PRG amb missatge d'èxit
            return redirect()->route('places.show', $place)
                ->with('success', __(':resource successfully saved', [
                    'resource' => __('resources.place')
                ]));
        } else {
            \Log::debug("Disk storage FAILS");
            // Patró PRG amb missatge d'error
            return redirect()->route("places.create")
                ->with('error', __('ERROR Uploading file'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function show(Place $place)
    {
        // Favorites counter
        $place->loadCount('favorites');
        
        return view("places.show", [
            'place'  => $place,
            'file'   => $place->file,
            'author' => $place->user,
            'numFavorites' => $place->favorites_count,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function edit(Place $place)
    {
        // Comprovar si l'usuari/a pot editar (PlacePolicy)
        $this->authorize('update', $place);

        return view("places.edit", [
            'place'  => $place,
            'file'   => $place->file,
            'author' => $place->user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Place $place)
    {
        // Comprovar si l'usuari/a pot editar (PlacePolicy)
        $this->authorize('update', $place);

        // Validar dades del formulari
        $validatedData = $request->validate([
            'name'        => 'required',
            'description' => 'required',
            'upload'      => 'nullable|mimes:gif,jpeg,jpg,png,mp4|max:2048',
            'latitude'    => 'required',
            'longitude'   => 'required',
            'visibility'  => 'required|exists:visibilities,id',
        ]);
        
        // Obtenir dades del formulari
        $name        = $request->get('name');
        $description = $request->get('description');
        $upload      = $request->file('upload');
        $latitude    = $request->get('latitude');
        $longitude   = $request->get('longitude');
        $visibility  = $request->get('visibility');

        // Desar fitxer (opcional)
        if (is_null($upload) || $place->file->diskSave($upload)) {
            // Actualitzar dades a BD
            Log::debug("Updating DB...");
            $place->name          = $name;
            $place->description   = $description;
            $place->latitude      = $latitude;
            $place->longitude     = $longitude;
            $place->visibility_id = $visibility;
            $place->save();
            \Log::debug("DB storage OK");
            // Patró PRG amb missatge d'èxit
            return redirect()->route('places.show', $place)
                ->with('success', __(':resource successfully updated', [
                    'resource' => __('resources.place')
                ]));
        } else {
            // Patró PRG amb missatge d'error
            return redirect()->route("places.create")
                ->with('error', __('ERROR Uploading file'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function destroy(Place $place)
    {
        // Comprovar si l'usuari/a pot eliminar (PlacePolicy)
        $this->authorize('delete', $place);
        
        // Eliminar place de BD
        $place->delete();

        // Eliminar fitxer associat del disc i BD
        $place->file->diskDelete();

        // Patró PRG amb missatge d'èxit
        return redirect()->route("places.index")
            ->with('success', __(':resource successfully deleted', [
                'resource' => __('resources.place')
            ]));
    }

    /**
     * Add favorite place
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function favorite(Place $place) 
    {
        $fav = Favorite::create([
            'user_id'  => auth()->user()->id,
            'place_id' => $place->id
        ]);

        return redirect()->back()
            ->with('success', __(':resource successfully saved', [
                'resource' => __('resources.favorite')
            ]));
    }

    /**
     * Undo favorite
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function unfavorite(Place $place) 
    {
        $fav = Favorite::where([
            ['user_id',  '=', auth()->user()->id],
            ['place_id', '=', $place->id],
        ])->first();
        
        $fav->delete();
        
        return redirect()->back()
            ->with('success', __(':resource successfully deleted', [
                'resource' => __('resources.favorite')
            ]));
    }
}
