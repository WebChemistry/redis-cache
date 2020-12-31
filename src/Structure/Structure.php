<?php declare(strict_types = 1);

namespace WebChemistry\RedisCache\Structure;

use Redis;

abstract class Structure
{

	public function __construct(
		protected Redis $redis,
		protected string $key,
	)
	{
	}

	public function key(): string
	{
		return $this->key;
	}

	public function unset(): int
	{
		return $this->redis->del($this->key);
	}

	public function isset(): bool
	{
		return (bool) $this->redis->exists($this->key);
	}

	public function rename(string $key): bool
	{
		$state = $this->redis->rename($this->key, $key);
		if (!$state) {
			return false;
		}

		$this->key = $key;

		return true;
	}

}
