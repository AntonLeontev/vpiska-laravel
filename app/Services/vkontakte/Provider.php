<?php

namespace App\Services\vkontakte;

use Illuminate\Support\Arr;
use SocialiteProviders\Manager\OAuth2\User;

class Provider extends \SocialiteProviders\VKontakte\Provider
{
	protected $fields = ['id', 'email', 'first_name', 'last_name', 'screen_name', 'photo_200', 'sex'];

	protected function mapUserToObject(array $user)
	{
		return (new User())->setRaw($user)->map([
			'id'         => Arr::get($user, 'id'),
			'nickname'   => Arr::get($user, 'screen_name'),
			'first_name' => Arr::get($user, 'first_name'),
			'last_name'  => Arr::get($user, 'last_name'),
			'email'      => Arr::get($user, 'email'),
			'avatar'     => Arr::get($user, 'photo_200'),
			'sex'        => Arr::get($user, 'sex'),
		]);
	}
}
