<?php

namespace App\Http\Controllers;

use App\Models\TelegramUser;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function telegramAuth(Request $request)
    {
        $data = $request->all();


        // Проверка подписи
        $check_hash = $data['hash']; // Берём хэш из данных
        unset($data['hash']); // Убираем хэш из данных для проверки


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


        // Создание или обновление пользователя
        $user = \App\Models\User::updateOrCreate(
            ['telegram_id' => $data['id']],
            [
                'name' => $data['first_name'] ?? null,
                'username' => $data['username'] ?? null,
                'avatar' => $data['photo_url'] ?? null,
            ]
        );

        // Генерация токена
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token]);

    }
}
