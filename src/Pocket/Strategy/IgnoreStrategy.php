<?php

namespace Kluzo\Pocket\Strategy;

use Kluzo\Pocket\PocketInterface as Pocket;
use Kluzo\Pocket\Aggregate\AggregateInterface as PocketAggregate;
use Kluzo\Pocket\Strategy\StrategyInterface as PocketStrategy;

class IgnoreStrategy implements PocketStrategy
{
	function findPocket(string $pocketName, PocketAggregate $pocketAggregate) : ?Pocket
	{
		return $pocketAggregate->getPocket($pocketName);
	}
}
