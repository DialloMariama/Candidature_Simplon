<?php

namespace App\Http\Controllers\API;


use Exception;
use Illuminate\Http\Request;
use App\Models\FormationUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FormationUserController extends Controller
{
    public function index()
{
    $candidatures = FormationUser::all();

    return response()->json([
        'status_code' => 200,
        'status_message' => 'Liste des candidatures',
        'data' => $candidatures,
    ]);
}



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

    // public function acceptCandidature(Request $request, $id)
    // {
    //     try {
    //         $candidature = FormationUser::findOrFail($id);

    //         if (Auth::user()->id === $candidature->formation->user_id) {
    //             if ($candidature->etat === 'En_cours') {
    //                 $candidature->etat = 'accepte';
    //                 $candidature->save();

    //                 return response()->json([
    //                     'status_code' => 200,
    //                     'status_message' => 'La candidature a été acceptée avec succès',
    //                     'data' => $candidature,
    //                 ]);
    //             } else {
    //                 return response()->json([
    //                     'status_code' => 400,
    //                     'status_message' => 'La candidature a déjà été traitée.',
    //                 ]);
    //             }
    //         } else {
    //             return response()->json([
    //                 'status_code' => 403,
    //                 'status_message' => 'Vous n\'êtes pas autorisé à accepter cette candidature',
    //             ]);
    //         }
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'status_code' => 500,
    //             'status_message' => 'Erreur lors de l\'acceptation de la candidature',
    //             'error' => $e->getMessage(),
    //         ]);
    //     }
    // }

//     public function rejectCandidature(Request $request, $id)
// {
//     try {
//         $candidature = FormationUser::findOrFail($id);
//         // dd($candidature);
//         // dd(Auth::user()->id, $candidature->formation->user_id);
//         if (Auth::user()->id === $candidature->formation->user_id) {
//             if ($candidature->formation && $candidature->etat === 'En_cours') {
//                 $candidature->etat = 'refuse';
//                 $candidature->save();

//                 return response()->json([
//                     'status_code' => 200,
//                     'status_message' => 'La candidature a été refusée avec succès',
//                     'data' => $candidature,
//                 ]);
//             } else {
//                 return response()->json([
//                     'status_code' => 400,
//                     'status_message' => 'La candidature n\'a pas de formation associée ou a déjà été traitée.',
//                 ]);
//             }
//         } else {
//             return response()->json([
//                 'status_code' => 403,
//                 'status_message' => 'Vous n\'êtes pas autorisé à refuser cette candidature',
//             ]);
//         }
//     } catch (Exception $e) {
//         return response()->json([
//             'status_code' => 500,
//             'status_message' => 'Erreur lors du refus de la candidature',
//             'error' => 'Une erreur s\'est produite lors du traitement de votre demande.',
//         ]);
//     }
// }
public function acceptedCandidatures()
{
    $acceptedCandidatures = FormationUser::where('etat', 'accepte')->get();

    return response()->json([
        'status_code' => 200,
        'status_message' => 'Liste des candidatures acceptées',
        'data' => $acceptedCandidatures,
    ]);
}
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
