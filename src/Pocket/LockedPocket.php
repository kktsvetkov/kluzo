<?php

namespace Kluzo\Pocket;

use Kluzo\Clue\ClueInterface as Clue;
use Kluzo\Pocket\PocketInterface as Pocket;
use Generator;

use const E_USER_WARNING;

use function iterator_count;
use function trigger_error;

class LockedPocket implements Pocket
{
	protected $clue;

	function __construct(Clue $clue)
	{
		$this->clue = $clue;;
	}

	function put(Clue $clue) : Pocket
	{
		trigger_error(
			'You can not put clues into a locked pocket',
			E_USER_WARNING);

		\Kluzo\Disguise::getInspector()->log('error', 'Can\'t put clues in locked pockets');

		return $this;
	}

	function clean() : Pocket
	{
		return $this;
	}

	function getIterator() : Generator
	{
		yield $this->clue;
	}

	function count() : int
	{
		return iterator_count($this->clue);
	}
}
