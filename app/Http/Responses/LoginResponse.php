<?php 
namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        // Récupération de l'utilisateur connecté 
        $user = $request->user();

        // Génération du token Sanctum (chaîne de caractères)
        $token = $user->createToken('auth_token', ['read', 'write'])->plainTextToken;
        
        // Retour personnalisé JSON
        return new JsonResponse([
            'message' => 'Login successfully',
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ], 200);
    }
}