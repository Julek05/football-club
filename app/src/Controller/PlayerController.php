<?php

declare(strict_types=1);

namespace App\Controller;

use App\CQRS\ReadModel\Query\GetPlayerQueryInterface;
use App\CQRS\WriteModel\Command\AddPlayerCommand;
use App\CQRS\WriteModel\Command\DeletePlayerCommand;
use App\CQRS\WriteModel\Exception\NotFoundPlayerException;
use App\Enum\HttpSuccessStatusCodeEnum;
use App\Request\Player\AddPlayerRequest;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
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

		return $this->success(null, HttpSuccessStatusCodeEnum::CREATED);
	}


	#[Route('/player/{id}', name: 'get_player', methods: ['GET'])]
	public function getPlayer(int $id, GetPlayerQueryInterface $getPlayerQuery): JsonResponse
	{
		try {
			$player = $getPlayerQuery->execute($id);
		} catch (\Throwable $e) {
			$this->logger->error($e->getMessage());

			return $this->internalServerError();
		}

		if ($player === null) {
			return $this->notFoundResponse();
		}

		return $this->success($player);
	}

	#[Route('/player/{id}', name: 'delete_player', methods: ['delete'])]
	public function deletePlayer(int $id): JsonResponse
	{
		try {
			$deletePlayerCommand = new DeletePlayerCommand($id);

			$this->bus->dispatch($deletePlayerCommand);
		} catch (HandlerFailedException $e) {
			if ($e->getPrevious() instanceof NotFoundPlayerException) {
				return $this->notFoundResponse();
			}

			$this->logger->error($e->getMessage());

			return $this->internalServerError();
		}

		return $this->success();
	}
}