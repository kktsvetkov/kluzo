<?php

namespace Kluzo\Inspector;

use Kluzo\Clue\ClueInterface as Clue;
use Kluzo\Clue\Ignore as IgnoreClue;
use Kluzo\Clue\Testimony as TestimonyClue;

use Kluzo\Inspector\AbstractInspector as Inspector;
use Kluzo\Inspector\StrategyAwareTrait;
use Kluzo\Pocket\StrategyInterface as PocketStrategyFinder;

class DetectiveInspector extends Inspector implements PocketStrategyFinder
{
	use StrategyAwareTrait;

	function log(string $pocketName, ...$things) : Clue
	{
		if ($this->caseSuspended)
		{
			return new IgnoreClue;
		}

		$pocketAggregate = $this->getPockets();
		if (!$pocket = $pocketAggregate->getPocket( $pocketName ))
		{
			if (!$pocketAggregate->isBlocked( $pocketName ))
			{
				$pocket = $this->getStrategy()->findPocket(
					$pocketName,
					$pocketAggregate
					);
			}

			if (!$pocket)
			{
				return new IgnoreClue;
			}
		}

		$pocket->put( $clue = new TestimonyClue(...$things) );
		return $clue;
	}

}
