<?php

declare(strict_types=1);

namespace App\Enum;

enum HttpSuccessStatusCodeEnum: int
{
	case OK = 200;

	case CREATED = 201;
}