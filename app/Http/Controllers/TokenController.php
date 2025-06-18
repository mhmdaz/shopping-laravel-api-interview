<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TokenController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/tokens/create",
     *     tags={"Tokens"},
     *     summary="Assign new tokens to users",
     *     description="Assign new tokens to users",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", example="john@example.com"),
     *             @OA\Property(property="password", type="string", example="password"),
     *             @OA\Property(property="token_name", type="string", example="some_random_token_name")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Token assigned successfully"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity"
     *     )
     * )
     */
    public function create(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $token = $request->user()->createToken($request->token_name ?? 'token', [$request->user()->role]);

            return ['token' => $token->plainTextToken];
        }

        return [];
    }
}
