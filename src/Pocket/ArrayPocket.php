<?php

namespace Kluzo\Pocket;

use Kluzo\Clue\ClueInterface as Clue;
use Kluzo\Pocket\PocketInterface as Pocket;
use Kluzo\Pocket\PocketInstructionTrait;
use Generator;

use array_filter;

class ArrayPocket implements Pocket
{
	use PocketInstructionTrait;
	
	protected $clues = array();

	function __construct(...$clues)
	{
		$this->clues = array_filter($clues, function($clue)
		{
			return $clue instanceOf Clue;
		});
	}

	function put(Clue $clue) : Pocket
	{
		$this->clues[] = $clue;
		return $this;
	}

	function clean() : Pocket
	{
		$this->clues = array();
		return $this;
	}

	function getIterator() : Generator
	{
		yield from $this->clues;
	}

	function count() : int
	{
		return count($this->clues);
	}
}
