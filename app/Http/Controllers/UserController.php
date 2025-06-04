<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest as UserValidationRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private function apiResponse($success, $message, $data = null, $status = 200)
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data' => $data
        ], $status);
    }

    public function authorisation(UserValidationRequest $request)
    {
        $validatedData = $request->validated();

        $user = User::where('email', $validatedData['email'])->first();

        if (!$user) {
            return $this->apiResponse(false, 'Пользователь не найден', null, 404);
        }
        
        if (!Hash::check($validatedData['password'], $user->password)) {
            return $this->apiResponse(false, 'Неверный пароль', null, 401);
        }
        
        $token = $user->createToken('api-token')->plainTextToken;

        return $this->apiResponse(true, 'Авторизация успешна', [
            'email' => $user->email,
            'token' => $token,
        ]);
    }

    public function register(UserValidationRequest $request)
    {
        $validatedData = $request->validated();

        $user = User::create([
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);
        
        return $this->apiResponse(true, 'Пользователь добавлен', [
            'email' => $user->email
        ]);
    }
}
