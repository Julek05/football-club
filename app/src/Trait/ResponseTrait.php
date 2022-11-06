<?php

declare(strict_types=1);

namespace App\Trait;

use App\Enum\HttpSuccessStatusCodeEnum;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ResponseTrait
{
	public function success(
		mixed $content = null,
		HttpSuccessStatusCodeEnum $statusCode = HttpSuccessStatusCodeEnum::OK
	): JsonResponse {
		if ($content === null) {
			return new JsonResponse(
				['message' => Response::$statusTexts[$statusCode->value]],
				$statusCode->value
			);
		}

		return new JsonResponse(
			[
				'message' => Response::$statusTexts[$statusCode->value],
				'content' => $content
			],
			$statusCode->value
		);
	}

	public function badRequest(string $errors): JsonResponse
	{
		return new JsonResponse(
			['errors' => $errors],
			Response::HTTP_OK
		);
	}

	public function internalServerError(): JsonResponse
	{
		return new JsonResponse(
			['message' => Response::$statusTexts[Response::HTTP_OK]],
			Response::HTTP_OK
		);
	}
}