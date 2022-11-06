<?php

declare(strict_types=1);

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

final class AddPlayerRequest
{
	#[Assert\NotBlank]
	#[Assert\Type('string')]
	public readonly mixed $name;

	#[Assert\NotBlank]
	#[Assert\Type('string')]
	public readonly mixed $surname;

	#[Assert\NotBlank]
	#[Assert\Type('int')]
	public readonly mixed $age;

	#[Assert\NotBlank]
	#[Assert\Type('string')]
	public readonly mixed $country;

	public function __construct(
		mixed $name,
		mixed $surname,
		mixed $age,
		mixed $country,
	) {
		$this->name = $name;
		$this->surname = $surname;
		$this->age = $age;
		$this->country = $country;
	}

	public static function fromAssociativeArray(array $requestArray): self
	{
		return new self(
			$requestArray['name'] ?? null,
			$requestArray['surname'] ?? null,
			$requestArray['age'] ?? null,
			$requestArray['country'] ?? null,
		);
	}
}