<?php

namespace Kluzo\Pocket\Strategy;

use Kluzo\Pocket\PocketInterface as Pocket;
use Kluzo\Pocket\Aggregate\AggregateInterface as PocketAggregate;

interface StrategyInterface
{
	function findPocket(string $pocketName, PocketAggregate $pocketAggregate) : ?Pocket;
}
