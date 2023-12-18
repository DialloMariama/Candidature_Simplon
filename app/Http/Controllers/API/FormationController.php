<?php

namespace App\Http\Controllers\API;


use App\Models\Formation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFormationRequest;
use App\Http\Requests\UpdateFormationRequest;


class FormationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required',
        ]);
        $formation = Formation::create([
            'nom' => $request->nom,
            'description' => $request->description,
        ]);
        return response()->json([
            'message' => 'Formation enregistrer avec succés',
            'formation' => $formation
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Formation $formation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Formation $formation)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $formation = Formation::findOrFail($id);
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required',
        ]);
        $formation->nom = $request->input('nom');
        $formation->description = $request->input('description');
        if($formation->update()){
            return response()->json([
                'formation'=>$formation,
                'message'=> 'Formation modifié',
            ]);
        }else{
            return response()->json([
                'message'=> 'Formation non modifié',
            ],404);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Formation $formation)
    {
        //
    }
}
