<?php

namespace Kluzo\Pocket;

use Kluzo\Pocket\Strategy\StrategyInterface as PocketStrategy;

interface StrategyInterface
{
	function getStrategy() : ?PocketStrategy;
}
