<?php

namespace App\Http\Controllers\API;


use App\Models\Formation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFormationRequest;
use App\Http\Requests\UpdateFormationRequest;

/**
 * @OA\Tag(
 *      name="Formations",
 *     description="Points de terminaison API pour la gestion des formations"
 * )
 */
class FormationController extends Controller
{

    
    /**
     * Display a listing of the resource.
     */
     /**
     * @OA\Get(
     *     path="/api/formations",
     *     summary="Liste de toutes les formations",
     *     tags={"Formations"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste de toutes les formations",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="formations", type="array", @OA\Items(type="object"))
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json([
            'message' => 'Liste de toutes les formations',
            'formation' => Formation::all()
        ]);
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
      /**
     * @OA\Post(
     *     path="/api/formations",
     *     summary="Enregistrer une nouvelle formation",
     *     tags={"Formations"},
     *     requestBody={"$ref": "#/components/requestBodies/FormationRequest"},
     *     @OA\Response(
     *         response=200,
     *         description="Formation enregistrée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="formation", type="object")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required',
            'duree' => 'required|integer',
        ]);
        $formation = Formation::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'duree' => $request->duree,
        ]);
        return response()->json([
            'message' => 'Formation enregistrer avec succés',
            'formation' => $formation
        ]);
    }
/**
     * @OA\RequestBody(
     *     request="FormationRequest",
     *     required=true,
     *     description="Données requises pour créer ou mettre à jour une formation",
     *     @OA\JsonContent(
     *         required={"nom", "description", "duree"},
     *         @OA\Property(property="nom", type="string", example="Nom de la formation"),
     *         @OA\Property(property="description", type="string", example="Description de la formation"),
     *         @OA\Property(property="duree", type="integer", example=30)
     *     )
     * )
     */
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
    /**
 * @OA\Put(
 *     path="/api/formations/{id}",
 *     summary="Mettre à jour une formation",
 *     tags={"Formations"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID de la formation à mettre à jour",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             ref="#/components/requestBodies/FormationRequest"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Formation modifiée avec succès",
 *         @OA\JsonContent(
 *             type="object",
 *             properties={
 *                 "message": {"type": "string"},
 *                 "formation": {"type": "object"}
 *             }
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Formation non trouvée",
 *         @OA\JsonContent(
 *             type="object",
 *             properties={"message": {"type": "string"}}
 *         )
 *     )
 * )
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

     /**
 * @OA\Delete(
 *     path="/api/formations/{id}",
 *     summary="Supprimer une formation",
 *     tags={"Formations"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID de la formation à supprimer",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Formation supprimée avec succès",
 *         @OA\JsonContent(
 *             type="object",
 *             properties={"message": {"type": "string"}}
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Formation non trouvée",
 *         @OA\JsonContent(
 *             type="object",
 *             properties={"message": {"type": "string"}}
 *         )
 *     )
 * )
 */
    public function destroy($id)
    {
        $formation = Formation::findOrFail($id);
        if($formation->delete()){
            return response()->json([
                'message'=> 'Formation supprimée',
            ]);
        }else{
            return response()->json([
                'message'=> 'Formation non supprimée',
            ],404);
        }
        
    }
}
