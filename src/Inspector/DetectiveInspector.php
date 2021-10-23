<?php

namespace Kluzo\Inspector;

use Kluzo\Clue\ClueInterface as Clue;
use Kluzo\Clue\Ignore as IgnoreClue;
use Kluzo\Clue\Testimony as TestimonyClue;

use Kluzo\Inspector\AbstractInspector as Inspector;

class DetectiveInspector extends Inspector
{
	function log(string $pocketName, ...$things) : Clue
	{
		if ($this->caseSuspended)
		{
			return new IgnoreClue;
		}

		if (!$pocket = $this->pocketAggregate->getPocket( $pocketName ))
		{
			return new IgnoreClue;
		}

		$pocket->put( $clue = new TestimonyClue(...$things) );
		return $clue;
	}
}
