<?php

namespace Kluzo\Clue;

use Kluzo\Clue\ClueInterface as Clue;
use Kluzo\Clue\MetaTrait;
use ArrayIterator;

class Ignore implements Clue
{
	use MetaTrait;

	function getIterator() : ArrayIterator
	{
		return new ArrayIterator([]);
	}
}
