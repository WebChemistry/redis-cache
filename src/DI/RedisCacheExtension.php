<?php declare(strict_types = 1);

namespace WebChemistry\RedisCache\DI;

use LogicException;
use Nette\DI\CompilerExtension;
use Nette\Http\Session;
use Nette\Schema\Expect;
use Nette\Schema\Schema;
use WebChemistry\RedisCache\Connection\RedisConnection;
use WebChemistry\RedisCache\Connection\RedisDatabases;

final class RedisCacheExtension extends CompilerExtension
{

	public function getConfigSchema(): Schema
	{
		return Expect::structure([
			'databases' => Expect::arrayOf(Expect::int()),
			'connection' => Expect::structure([
				'host' => Expect::string()->required(),
				'port' => Expect::int(6379),
			]),
		]);
	}

	public function loadConfiguration(): void
	{
		$builder = $this->getContainerBuilder();
		$config = $this->getConfig();

		$def = $builder->addDefinition($this->prefix('databases'))
			->setAutowired(false)
			->setFactory(RedisDatabases::class);

		foreach ($config->databases as $namespace => $index) {
			$def->addSetup('add', [$namespace, $index]);
		}

		$builder->addDefinition($this->prefix('connection'))
			->setFactory(RedisConnection::class, [$config->connection->host, $config->connection->port, $def]);
	}

}
