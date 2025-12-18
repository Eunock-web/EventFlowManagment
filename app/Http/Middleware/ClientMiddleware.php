<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;    
use Illuminate\Support\Facades\Auth; 

class ClientMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if($user->role !== 'client'){
            return new JsonResponse([
                'message' => 'Unauthorized. Client access only.'
            ], 403);
        }

        return $next($request);
    }
}
