<?php declare(strict_types = 1);

namespace WebChemistry\RedisCache\Connection;

use InvalidArgumentException;

final class RedisDatabases
{

	/** @var int[] */
	private array $databases = [];

	public function add(string $namespace, int $id): void
	{
		if ($id > 15) {
			throw new InvalidArgumentException('Maximum index of redis database is 15');
		}

		if ($id < 0) {
			throw new InvalidArgumentException('Minimum index of redis database is 0');
		}

		$this->databases[$namespace] = $id;
	}

	public function get(string $database): int
	{
		return $this->databases[$database] ?? throw new InvalidArgumentException(sprintf('Redis database %s not exists', $database));
	}

}
