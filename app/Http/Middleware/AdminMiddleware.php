<?php

namespace App\Http\Middleware;

use App\Models\Role;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        $user = User::where('email', $request->email)->first();
        if ($user->role_id !== Role::SUPERADMIN || !$user)
        {
            return response()->json([
                'authenticated' => false,
                'message' => 'You are not authorized to login as admin'
            ], 401);
        }
        return $next($request);
    
    }
}
