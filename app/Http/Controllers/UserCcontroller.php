<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserCcontroller extends Controller
{
    public function authorisation(Request $request)
    {
        $validatedData = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6'],
        ]);

        $user = User::where('email', $validatedData['email'])->first();

        if (!$user) {
            return response()->json([
                'message' => 'Пользователь не найден'
            ], 
                404
            );
        }
        
        if (!Hash::check($validatedData['password'], $user->password)) {
            return response()->json([
                'message' => 'Неверный пароль'
            ], 
                401
            );
        }
        
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Авторизация успешна',
            'email' => $user->email,
            'token' => $token,
        ]);
    }
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6'],
        ]);

        $user = User::create([
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
        ]);
        
        return response()->json([
            'message' => 'Пользователь добавлен', 
            'email' => $user->email
        ]);
    }
}
