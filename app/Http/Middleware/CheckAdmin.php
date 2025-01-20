<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Получаем текущего пользователя
        $user = $request->user();  // В случае если токен аутентифицирован через Sanctum

        if ($user && $user->is_admin) {  // Проверяем, является ли пользователь администратором
            return $next($request);  // Разрешаем выполнение запроса, если это администратор
        }

        // Если пользователь не администратор, возвращаем ошибку 403
        return response()->json(['error' => 'Forbidden'], Response::HTTP_FORBIDDEN);

    }
}
