<?php

namespace App\Http\Controllers\API;


use Exception;
use Illuminate\Http\Request;
use App\Models\FormationUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FormationUserController extends Controller
{
    public function index(){

    }


    public function store(Request $request)
    {
        try {
            $user = Auth::user();

            // Utilisez un nom de variable plus explicite
            $candidature = new FormationUser();
            $candidature->user_id = $user->id;
            $candidature->formation_id = $request->formation_id;

            // Vérifiez si la sauvegarde a réussi
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
            // Utilisez un message d'erreur plus explicite et évitez de retourner l'exception brute
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Erreur lors de la candidature',
                'error' => $e->getMessage(),
            ]);
        }
    }

}
