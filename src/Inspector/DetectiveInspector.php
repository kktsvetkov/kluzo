<?php

namespace Kluzo\Inspector;

use Kluzo\Clue\ClueInterface as Clue;
use Kluzo\Clue\Ignore as IgnoreClue;
use Kluzo\Clue\Testimony as TestimonyClue;

use Kluzo\Inspector\AbstractInspector as Inspector;
use Kluzo\Pocket\StrategyInterface as PocketStrategyFinder;
use Kluzo\Pocket\Strategy\StrategyInterface as PocketStrategy;
use Kluzo\Pocket\Strategy\CreateStrategy as DefaultPocketStrategy;

class DetectiveInspector extends Inspector implements PocketStrategyFinder
{
	function log(string $pocketName, ...$things) : Clue
	{
		if ($this->caseSuspended)
		{
			return new IgnoreClue;
		}

		$pocketAggregate = $this->getPockets();
		if (!$pocket = $pocketAggregate->getPocket( $pocketName ))
		{
			$pocket = $this->getStrategy()->findPocket(
				$pocketName,
				$pocketAggregate
				);

			if (!$pocket)
			{
				return new IgnoreClue;
			}
		}

		$pocket->put( $clue = new TestimonyClue(...$things) );
		return $clue;
	}

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
