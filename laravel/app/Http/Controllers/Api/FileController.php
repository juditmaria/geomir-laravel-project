<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\File;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => File::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        // Validar fitxer
        $validatedData = $request->validate([
            'upload' => 'required|mimes:gif,jpeg,jpg,png|max:2048'
        ]);
        // Desar fitxer al disc i inserir dades a BD
        $upload = $request->file('upload');
        $file = new File();
        $ok = $file->diskSave($upload);
  
        if ($ok) {
            return response()->json([
                'success' => true,
                'data'    => $file
            ], 201);
        } else {
            return response()->json([
                'success'  => false,
                'message' => 'Error uploading file'
            ], 500);
        }
    }
 

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $file = File::find($id);
    
        if ($file) {
            return response()->json([
                'success' => true,
                'data' => $file
            ]);
        } else {
            return response()->json([
                'success'  => false,
                'message' => 'File not found'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function update(Request $request, $id)
    {
    // Buscar archivo en BD
    $file = File::find($id);

    if ($file) {
        // Validar archivo
        $validatedData = $request->validate([
            'upload' => 'required|mimes:gif,jpeg,jpg,png|max:2048'
        ]);

        // Guardar archivo en disco e actualizar datos en BD
        $upload = $request->file('upload');
        $ok = $file->diskSave($upload);

        if ($ok) {
            return response()->json([
                'success' => true,
                'data' => $file
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'File error'
            ], 422);
        }
    } else {
        return response()->json([
            'success' => false,
            'message' => 'File not found'
        ], 404);
    }
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $file = File::find($id);

        if ($file) {
            return response()->json([
                'success' => true,
                'data'    => $file
            ]);
        } else {
            return response()->json([
                'success'  => false,
                'message' => 'Error uploading file'
            ], 404);
        }
    }
    
}
