<?php

namespace App\Http\Middleware;

use App\Users\Models\User;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $requestToken = $request->header('Authorization');

        if (is_null($requestToken)) {
            return response()->json(['permission_denied' => 'Need a token'], 403);
        }

        /** @var User $userModel */
        $userModel = User::query()
            ->where('token', '=', $requestToken)
            ->first();

        if (is_null($userModel)) {
            return response()->json(['permission_denied' => 'incorrect token'], 403);
        }

        $request->merge(['user_id' => $userModel->user_id]);
        return $next($request);
    }
}
