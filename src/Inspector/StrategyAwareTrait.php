<?php

namespace Kluzo\Inspector;

use Kluzo\Pocket\Strategy\StrategyInterface as PocketStrategy;
use Kluzo\Pocket\Strategy\CreateStrategy as DefaultPocketStrategy;

trait StrategyAwareTrait
{
	protected $strategy;

	function setStrategy(PocketStrategy $strategy) : self
	{
		$this->strategy = $strategy;
		return $this;
	}

	function getStrategy() : ?PocketStrategy
	{
		return $this->strategy ?? (
			$this->strategy = new DefaultPocketStrategy
			);
	}
}
