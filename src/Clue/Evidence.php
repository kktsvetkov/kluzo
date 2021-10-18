<?php

namespace Kluzo\Clue;

use Kluzo\Clue\ClueInterface as Clue;
use Generator;

class Evidence implements Clue
{
	protected $callback;

	function __construct(callable $callback)
	{
		$this->callback = $callback;
	}

	function getIterator() : Generator
	{
		if (!$callback = $this->callback)
		{
			return [];
		}

		yield from $callback();
	}
}
