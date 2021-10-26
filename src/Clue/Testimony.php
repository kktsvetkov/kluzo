<?php

namespace Kluzo\Clue;

use Kluzo\Clue\ClueInterface as Clue;
use Kluzo\Clue\FormatTrait;
use Kluzo\Clue\LabelTrait;
use Exception;
use Generator;

class Testimony extends Exception implements Clue
{
	use FormatTrait;
	use LabelTrait;

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
