<?php declare(strict_types = 1);

namespace WebChemistry\RedisCache\Connection;

use Redis;
use RedisException;
use WebChemistry\RedisCache\RedisCache;

final class RedisConnection
{

	/** @var RedisCache[] */
	private array $connections = [];

	public function __construct(
		private string $host,
		private int $port,
		private RedisDatabases $databases,
	)
	{
	}

	public function get(?string $database = null): RedisCache
	{
		$index = 0;
		if ($database) {
			$index = $this->databases->get($database);
		}

		if (!isset($this->connections[$index])) {
			$this->connections[$index] = new RedisCache(function () use ($index): Redis {
				$redis = new Redis();
				$redis->connect($this->host, $this->port);
				if ($index !== 0 && !$redis->select($index)) {
					throw new RedisException(sprintf('Cannot change db index to %d', $index));
				}

				return $redis;
			});
		}

		return $this->connections[$index];
	}

}
