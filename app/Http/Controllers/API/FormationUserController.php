<?php

namespace App\Http\Controllers\API;


use Exception;
use Illuminate\Http\Request;
use App\Models\FormationUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Tag(
 *     name="Candidatures",
 *     description="Points de terminaison API pour la gestion des candidatures aux formations"
 * )
 */
class FormationUserController extends Controller
{
    
        /**
         * @OA\Get(
         *     path="/api/candidatures",
         *     summary="Liste des candidatures",
         *     tags={"Candidatures"},
         *     @OA\Response(
         *         response=200,
         *         description="Liste des candidatures",
         *         @OA\JsonContent(
         *             type="object",
         *             properties={
         *                 "status_code": {"type": "integer"},
         *                 "status_message": {"type": "string"},
         *                 "data": {"type": "array", "items": {"type": "object"}}
         *             }
         *         )
         *     )
         * )
         */
    public function index()
    {
        $candidatures = FormationUser::all();

        return response()->json([
            'status_code' => 200,
            'status_message' => 'Liste des candidatures',
            'data' => $candidatures,
        ]);
    }
 /**
     * @OA\Post(
     *     path="/api/candidatures",
     *     summary="Effectuer une candidature",
     *     tags={"Candidatures"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"formation_id"},
     *             @OA\Property(property="formation_id", type="integer"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Candidature effectuée avec succès",
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 "status_code": {"type": "integer"},
     *                 "status_message": {"type": "string"},
     *                 "data": {"type": "object"}
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Échec de la sauvegarde de la candidature",
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 "status_code": {"type": "integer"},
     *                 "status_message": {"type": "string"}
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erreur lors de la candidature",
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 "status_code": {"type": "integer"},
     *                 "status_message": {"type": "string"},
     *                 "error": {"type": "string"}
     *             }
     *         )
     *     )
     * )
     */


    public function store(Request $request)
    {
        try {
            $user = Auth::user();

            $candidature = new FormationUser();
            $candidature->user_id = $user->id;
            $candidature->formation_id = $request->formation_id;

            if ($candidature->save()) {
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'La candidature a été effectuée avec succès',
                    'data' => $candidature
                ]);
            } else {
                return response()->json([
                    'status_code' => 500,
                    'status_message' => 'Échec de la sauvegarde de la candidature',
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Erreur lors de la candidature',
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/AccepterCandidatures/{candidature}",
     *     summary="Accepter une candidature",
     *     tags={"Candidatures"},
     *     @OA\Parameter(
     *         name="candidature",
     *         in="path",
     *         description="ID de la candidature à accepter",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Candidature acceptée avec succès",
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 "status_code": {"type": "integer"},
     *                 "status_message": {"type": "string"},
     *                 "data": {"type": "object"}
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur lors de l'acceptation de la candidature",
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 "status_code": {"type": "integer"},
     *                 "status_message": {"type": "string"}
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="La candidature a déjà été traitée",
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 "status_code": {"type": "integer"},
     *                 "status_message": {"type": "string"}
     *             }
     *         )
     *     )
     * )
     */
    public function accepterCandidature(FormationUser $candidature)
    {
        if ($candidature->etat === 'en_cours') {
            $candidature->etat = 'accepte';
            if ($candidature->save()) {
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'La candidature a été acceptée avec succès',
                    'data' => $candidature,
                ]);
            } else {
                return response()->json([
                    'status_code' => 500,
                    'status_message' => 'Erreur lors de l\'acceptation de la candidature',
                ]);
            }
        } else {
            return response()->json([
                'status_code' => 400,
                'status_message' => 'La candidature a déjà été traitée.',
            ]);
        }
    }

    
    /**
     * @OA\Put(
     *     path="/api/RefuserCandidatures/{candidature}",
     *     summary="Refuser une candidature",
     *     tags={"Candidatures"},
     *     @OA\Parameter(
     *         name="candidature",
     *         in="path",
     *         description="ID de la candidature à refuser",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Candidature refusée avec succès",
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 "status_code": {"type": "integer"},
     *                 "status_message": {"type": "string"},
     *                 "data": {"type": "object"}
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur lors du refus de la candidature",
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 "status_code": {"type": "integer"},
     *                 "status_message": {"type": "string"}
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="La candidature a déjà été traitée",
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 "status_code": {"type": "integer"},
     *                 "status_message": {"type": "string"}
     *             }
     *         )
     *     )
     * )
     */
    

    public function refuserCandidature(FormationUser $candidature)
    {
        if ($candidature->etat === 'en_cours') {
            $candidature->etat = 'refuse';
            if ($candidature->save()) {
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'La candidature a été refusée avec succès',
                    'data' => $candidature,
                ]);
            } else {
                return response()->json([
                    'status_code' => 500,
                    'status_message' => 'Erreur lors du refus de la candidature',
                ]);
            }
        } else {
            return response()->json([
                'status_code' => 400,
                'status_message' => 'La candidature a déjà été traitée.',
            ]);
        }
    }
/**
     * @OA\Get(
     *     path="/api/candidaturesAcceptees",
     *     summary="Liste des candidatures acceptées",
     *     tags={"Candidatures"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des candidatures acceptées",
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 "status_code": {"type": "integer"},
     *                 "status_message": {"type": "string"},
     *                 "data": {"type": "array", "items": {"type": "object"}}
     *             }
     *         )
     *     )
     * )
     */

    public function acceptedCandidatures()
    {
        $acceptedCandidatures = FormationUser::where('etat', 'accepte')->get();

        return response()->json([
            'status_code' => 200,
            'status_message' => 'Liste des candidatures acceptées',
            'data' => $acceptedCandidatures,
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/candidaturesRejetees",
     *     summary="Liste des candidatures refusées",
     *     tags={"Candidatures"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des candidatures refusées",
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 "status_code": {"type": "integer"},
     *                 "status_message": {"type": "string"},
     *                 "data": {"type": "array", "items": {"type": "object"}}
     *             }
     *         )
     *     )
     * )
     */
    public function rejectedCandidatures()
    {
        $rejectedCandidatures = FormationUser::where('etat', 'refuse')->get();

        return response()->json([
            'status_code' => 200,
            'status_message' => 'Liste des candidatures refusées',
            'data' => $rejectedCandidatures,
        ]);
    }
}
