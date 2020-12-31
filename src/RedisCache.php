<?php declare(strict_types = 1);

namespace WebChemistry\RedisCache;

use Redis;
use WebChemistry\RedisCache\Structure\ListStructure;
use WebChemistry\RedisCache\Structure\SetStructure;
use WebChemistry\RedisCache\Structure\SortedSetStructure;

class RedisCache
{

	/** @var callable */
	private $factory;

	private Redis $redis;

	public function __construct(callable $factory)
	{
		$this->factory = $factory;
	}

	protected function getRedis(): Redis
	{
		if (!isset($this->redis)) {
			$this->redis = ($this->factory)();
		}

		return $this->redis;
	}

	public function set(string $key): SetStructure
	{
		return new SetStructure($this->getRedis(), $key);
	}

	public function sortedSet(string $key): SortedSetStructure
	{
		return new SortedSetStructure($this->getRedis(), $key);
	}

	public function list(string $key): ListStructure
	{
		return new ListStructure($this->getRedis(), $key);
	}

}
