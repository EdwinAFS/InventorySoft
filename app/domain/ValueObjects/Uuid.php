<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

class Uuid
{
	protected $value;

	public function __construct(string $value)
	{
		$this->ensureIsValidUuid($value);

		$this->value = $value;
	}

	public static function random(): self
	{
		$uuid =  sprintf(
			'%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
			mt_rand(0, 0xffff),
			mt_rand(0, 0xffff),
			mt_rand(0, 0xffff),
			mt_rand(0, 0x0fff) | 0x4000,
			mt_rand(0, 0x3fff) | 0x8000,
			mt_rand(0, 0xffff),
			mt_rand(0, 0xffff),
			mt_rand(0, 0xffff)
		);

		return new static( $uuid );
	}

	public function value(): string
	{
		return $this->value;
	}

	public function equals(Uuid $other): bool
	{
		return $this->value() === $other->value();
	}

	public function __toString(): string
	{
		return $this->value();
	}

	private function ensureIsValidUuid($id): void
	{
		if ( false ) {
			throw new InvalidArgumentException(sprintf('<%s> does not allow the value <%s>.', static::class, $id));
		}
	}
}
