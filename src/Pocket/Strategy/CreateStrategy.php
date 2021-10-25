<?php

namespace Kluzo\Pocket\Strategy;

use Kluzo\Pocket\ArrayPocket as DefaultPocket;
use Kluzo\Pocket\PocketInterface as Pocket;
use Kluzo\Pocket\Aggregate\AggregateInterface as PocketAggregate;
use Kluzo\Pocket\Strategy\StrategyInterface as PocketStrategy;

class CreateStrategy implements PocketStrategy
{
	protected $createPocketCallback;

	function __construct(callable $createPocketCallback = null)
	{
		$this->createPocketCallback = $createPocketCallback;
	}

	function findPocket(string $pocketName, PocketAggregate $pocketAggregate) : ?Pocket
	{
		if ($pocket = $pocketAggregate->getPocket($pocketName))
		{
			return $pocket;
		}

		$createPocketCallback = $this->createPocketCallback
			?? static function()
			{
				return new DefaultPocket;
			};

		$newPocket = $createPocketCallback();
		$pocketAggregate->addPocket(
			$pocketName,
			$newPocket->with('new.pocket')
			);

		return $newPocket;
	}
}
