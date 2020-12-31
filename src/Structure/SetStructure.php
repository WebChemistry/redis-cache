<?php declare(strict_types = 1);

namespace WebChemistry\RedisCache\Structure;

final class SetStructure extends Structure
{

	public function add(mixed ...$values): self
	{
		$this->redis->sAdd($this->key, ...$values);

		return $this;
	}

}
