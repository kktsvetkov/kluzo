<?php

namespace Kluzo\Clue;

use Kluzo\Clue\ClueInterface as Clue;
use ArrayIterator;

class Ignore implements Clue
{
	function getIterator() : ArrayIterator
	{
		return new ArrayIterator([]);
	}
}
