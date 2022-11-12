<?php

namespace App\Enums;

enum OrderStatus: int
{
	case Undefined = 0;
	case Accepted = 1;
	case Declined = 2;
}
