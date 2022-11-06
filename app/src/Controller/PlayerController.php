<?php

declare(strict_types=1);

namespace App\Controller;

use App\CQRS\ReadModel\Query\GetPlayerQueryInterface;
use App\CQRS\WriteModel\Command\AddPlayerCommand;
use App\Request\AddPlayerRequest;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Log\Logger;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Trait\ResponseTrait;

class PlayerController extends AbstractController
{
	use ResponseTrait;

	public function __construct(
		private readonly MessageBusInterface $bus,
		private readonly ValidatorInterface $validator,
		private readonly LoggerInterface $logger
	) {
	}

	#[Route('/player', name: 'add_player', methods: ['POST'])]
	public function addPlayer(Request $request): JsonResponse
	{
		try {
			$addPlayerRequest = AddPlayerRequest::fromAssociativeArray($request->toArray());

			/** @var ConstraintViolationList $errors */
			$errors = $this->validator->validate($addPlayerRequest);

			if (count($errors) > 0) {
				return $this->badRequest((string)$errors);
			}

			$addPlayerCommand = new AddPlayerCommand(
				Uuid::v4(),
				$addPlayerRequest->name,
				$addPlayerRequest->surname,
				$addPlayerRequest->age,
				$addPlayerRequest->country,
			);

			$this->bus->dispatch($addPlayerCommand);
		} catch (\Throwable $e) {
			$this->logger->error($e->getMessage());

			return $this->internalServerError();
		}

		return $this->success(['id' => $addPlayerCommand->id]);
	}


	#[Route('/player/{id}', name: 'get_player', methods: ['GET'])]
	public function getPlayer(string $id, GetPlayerQueryInterface $getPlayerQuery): JsonResponse
	{
		if (Uuid::isValid($id) === false) {
			$this->badRequest('Id is not valid');
		}

		return $this->success($getPlayerQuery->execute(Uuid::fromString($id)));
	}
}