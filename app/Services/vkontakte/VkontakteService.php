<?php

namespace App\Services\vkontakte;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class VkontakteService
{
	public function getUser(): User
	{
		$vkUser = Socialite::driver('vkontakte')->user();

		$user = User::firstOrCreate(['email' => $vkUser->getEmail()], [
			'vk_id'             => $vkUser->getId(),
			'first_name'        => $vkUser->first_name,
			'last_name'         => $vkUser->last_name,
			'photo_path'        => $vkUser->getAvatar(),
			'password'          => Hash::make(str()->random(12)),
			'email_verified_at' => now(),
			'sex'               => $this->convertSex($vkUser->sex),
		]);

		return $user;
	}

	private function convertSex(int $sex): string
	{
		switch ($sex) {
			case 1:
				return 'female';
			case 2:
				return 'male';
			default:
				return 'undefined';
		}
	}
}
