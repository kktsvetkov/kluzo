<?php

namespace Kluzo\Clue;

use Kluzo\Clue\ClueInterface as Clue;
use Kluzo\Clue\FormatTrait;
use Kluzo\Clue\LabelTrait;
use ArrayIterator;

class Ignore implements Clue
{
	use FormatTrait;
	use LabelTrait;

	function getIterator() : ArrayIterator
	{
		return new ArrayIterator([]);
	}
}
