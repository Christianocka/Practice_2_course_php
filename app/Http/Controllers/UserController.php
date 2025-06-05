<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponse;
use App\Http\Requests\UserLoginRequest as LoginValidationRequest;
use App\Http\Requests\UserRegisterRequest as UserRegisterRequest;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    use ApiResponse;

    public function authorisation(LoginValidationRequest $request)
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

    public function register(UserRegisterRequest $request)
    {
        $validatedData = $request->validated();

        $user = User::create([
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'password_confirmation'=> $validatedData['password_confirmation'],
        ]);
        
        return $this->apiResponse(true, 'Пользователь добавлен', [
            'email' => $user->email
        ]);
    }
}
