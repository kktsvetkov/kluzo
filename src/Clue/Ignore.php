<?php

namespace Kluzo\Clue;

use Kluzo\Clue\ClueInterface as Clue;
use Kluzo\Clue\LabelTrait;
use ArrayIterator;

class Ignore implements Clue
{
	use LabelTrait;

	function getIterator() : ArrayIterator
	{
		return new ArrayIterator([]);
	}
}
