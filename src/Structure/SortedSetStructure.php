<?php declare(strict_types = 1);

namespace WebChemistry\RedisCache\Structure;

final class SortedSetStructure extends Structure
{

	public function add(mixed $value, int|float $score): self
	{
		$this->redis->zAdd($this->key, [], $score, $value);

		return $this;
	}

	/**
	 * @param mixed[] $values
	 */
	public function addMany(array $values): self
	{
		$this->redis->zAdd($this->key, [], ...$values);

		return $this;
	}

	public function count(): int
	{
		return $this->redis->zCard($this->key);
	}

	/**
	 * @return mixed[]
	 */
	public function members(): array
	{
		return $this->range(0, -1);
	}

	/**
	 * @return mixed[]
	 */
	public function range(int $start, int $end): array
	{
		return $this->redis->zRevRange($this->key, $start, $end, false);
	}

}
