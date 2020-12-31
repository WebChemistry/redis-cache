<?php declare(strict_types = 1);

namespace WebChemistry\RedisCache\Structure;

final class ListStructure extends Structure
{

	public function push(mixed $value): int
	{
		return $this->redis->rPush($this->key, $value);
	}

	/**
	 * @param mixed[] $values
	 */
	public function pushMany(array $values): int
	{
		return $this->redis->rPush($this->key, ...$values);
	}

	public function count(): int
	{
		return $this->redis->lLen($this->key);
	}

	/**
	 * @return mixed[]
	 */
	public function members(): array
	{
		return $this->redis->lRange($this->key, 0, -1);
	}

}
