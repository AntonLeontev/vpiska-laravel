<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Services\vkontakte\VkontakteService;

class VkontakteController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('vkontakte')->redirect();
    }

    public function callback(VkontakteService $service)
    {
        try {
            $user = $service->getUser();
        } catch (\Throwable $th) {
            // TODO Error message
            Log::critical('Ошибка при авторизации в ВК', [$th->getMessage()]);
            return redirect(route('home'));
        }

        Auth::login($user, true);

        return back();
    }
}
