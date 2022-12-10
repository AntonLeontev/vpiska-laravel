<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;


trait HasMoneyAttribute
{
	protected function moneyAttribute(): Attribute
	{
		return Attribute::make(
			get: fn ($value) => ($value / 100),
			set: fn ($value) => ($value * 100)
		);
	}
}
