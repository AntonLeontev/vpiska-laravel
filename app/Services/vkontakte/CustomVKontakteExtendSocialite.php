<?php

namespace App\Services\vkontakte;

use SocialiteProviders\Manager\SocialiteWasCalled;

class CustomVKontakteExtendSocialite
{
	public function handle(SocialiteWasCalled $socialiteWasCalled)
	{
		$socialiteWasCalled->extendSocialite('vkontakte', Provider::class);
	}
}
