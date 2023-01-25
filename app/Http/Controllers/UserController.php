<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Exception;

class UserController extends Controller
{
    public function register(UserRegisterRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if (! auth()->attempt($credentials)) {
                abort(401, 'Invalid credentials');
            }

            /** @var User $user */
            $user = auth()->user();
            $token = $user->createToken('access-token');

            return response()->json([
                'data' => [
                    'token' => $token->plainTextToken
                ]
            ], 200);
        } catch (Exception $exception) {
            return response()->json(
                ['error' => $exception->getMessage()],
                $exception->getCode()
            );
        }
    }
}
