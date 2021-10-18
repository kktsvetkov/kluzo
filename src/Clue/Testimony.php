<?php

namespace Kluzo\Clue;

use Kluzo\Clue\ClueInterface as Clue;
use Exception;
use Generator;

class Testimony extends Exception implements Clue
{
	protected $things = array();

	function __construct(...$things)
	{
		$this->things = $things;
	}

	function getIterator() : Generator
	{
		yield from $this->things;
	}
}
