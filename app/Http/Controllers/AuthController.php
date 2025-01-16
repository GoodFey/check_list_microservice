<?php

namespace App\Http\Controllers;

use App\Models\TelegramUser;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function telegramAuth(Request $request)
    {
        $data = $request->all();

        // Проверка подписи
        $check_hash = $data['hash'];
        unset($data['hash']);
        $data_check_array = [];
        foreach ($data as $key => $value) {
            $data_check_array[] = $key . '=' . $value;
        }
        sort($data_check_array);
        $data_check_string = implode("\n", $data_check_array);

        $secret_key = hash('sha256', env('TELEGRAM_BOT_TOKEN'), true);
        $hash = hash_hmac('sha256', $data_check_string, $secret_key);

        if (!hash_equals($hash, $check_hash)) {
            return response()->json(['error' => 'Invalid data'], 401);
        }

        // Авторизация или регистрация пользователя
        $user = TelegramUser::updateOrCreate(
            ['telegram_id' => $data['id']],
            [
                'name' => $data['first_name'] ?? null,
                'username' => $data['username'] ?? null,
                'avatar' => $data['photo_url'] ?? null,
            ]
        );

        // Создаем JWT токен
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }

}
