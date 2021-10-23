<?php

namespace Kluzo\Pocket;

use Kluzo\Clue\ClueInterface as Clue;
use Kluzo\Pocket\PocketInterface as Pocket;
use Generator;

use function iterator_count;

class LockedPocket implements Pocket
{
	protected $clue;

	function __construct(Clue $clue)
	{
		$this->clue = $clue;;
	}

	function put(Clue $clue) : Pocket
	{
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
