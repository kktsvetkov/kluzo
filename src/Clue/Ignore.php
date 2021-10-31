<?php

namespace Kluzo\Clue;

use Kluzo\Clue\ClueInterface as Clue;
use Kluzo\Clue\MetaTrait;
use ArrayIterator;

/**
* Ignore Clue
*
* Ignore clues carry no information and they are used whenever it
* is certain features are disabled: it is neceseary to not break
* the method signature and return a clue when a clue is expected
*/
class Ignore implements Clue
{
	use MetaTrait;

	function getIterator() : ArrayIterator
	{
		return new ArrayIterator([]);
	}
}
