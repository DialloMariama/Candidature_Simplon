<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Formation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * @OA\Tag(
 *      name="Authentification",
 *     description="Points de terminaison API pour l'authentification ,l'inscription affichage des informations, la deconnexion et raffrechissement des tokens des utilisateurs"
 * )
 */
class AuthController extends Controller
{
     /**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"Authentification"},
     *     summary="Connecter un utilisateur existant",
     *     description="Connectez-vous avec un e-mail et un mot de passe pour obtenir un jeton d'authentification",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="email", type="string", example="utilisateur@example.com"),
     *                 @OA\Property(property="password", type="string", example="motdepasse"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Connexion réussie",
     *         @OA\JsonContent(
     *             @OA\Property(property="user", type="object", description="Détails de l'utilisateur"),
     *             @OA\Property(property="authorization", type="object", description="Détails d'autorisation"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Non autorisé",
     *     ),
     * )
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');
        $token = Auth::attempt($credentials);

        if (!$token) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

     /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Enregistrer un nouvel utilisateur",
     *     tags={"Authentification"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"matricule", "nom", "prenom", "telephone", "email", "password"},
     *             @OA\Property(property="matricule", type="string"),
     *             @OA\Property(property="nom", type="string"),
     *             @OA\Property(property="prenom", type="string"),
     *             @OA\Property(property="telephone", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="user", type="object")
     *         )
     *     )
     * )
     */
    private function generateMatricule()
    {
        $currentYear = date('Y');
        $lastUserId = User::max('id');
        $matricule = $lastUserId . $currentYear . 'Simplon';
        return $matricule;
    }
    public function register(Request $request)
    {
        $request->validate([
            // 'matricule' => 'required|string|max:20',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|max:14',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'matricule' => $this->generateMatricule(),
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ]);
    }
     /**
     * @OA\Get(
     *     path="/api/informationUser",
     *     summary="Afficher les informations de l'utilisateur connecté",
     *     tags={"Authentification"},
     *     @OA\Response(
     *         response=200,
     *         description="Détails de l'utilisateur connecté",
     *         @OA\JsonContent(
     *             type="object"
     *         )
     *     )
     * )
     */
    public function informationUser()
    {
        return response()->json(auth()->user());
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Déconnexion d'un utilisateur",
     *     tags={"Authentification"},
     *     @OA\Response(
     *         response=200,
     *         description="Déconnexion réussie",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function logout()
    {
        Auth::logout();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }
    /**
     * @OA\Post(
     *     path="/api/refresh",
     *     summary="Actualiser le jeton d'authentification",
     *     tags={"Authentification"},
     *     @OA\Response(
     *         response=200,
     *         description="Jeton d'authentification actualisé",
     *         @OA\JsonContent(
     *             @OA\Property(property="user", type="object")
     *         )
     *     )
     * )
     */

    public function refresh()
    {
        return response()->json([
            'user' => Auth::user(),
            'authorization' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

   
}
