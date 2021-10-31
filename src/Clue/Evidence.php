<?php

namespace Kluzo\Clue;

use Kluzo\Clue\ClueInterface as Clue;
use Kluzo\Clue\MetaTrait;
use Generator;

/**
* Evidence Clue
*
* Evidence clues are meant to return immutable variables, which are
* returned from a callback. They do have formats and labels, but there
* is no trace as it is pointless for this type of clue
*/
class Evidence implements Clue
{
	use MetaTrait;

	/**
	* @var callable
	*/
	protected $callback;

	/**
	* Constructor
	*
	* @param callable $evidenceCallback
	*/
	function __construct(callable $evidenceCallback)
	{
		$this->callback = $evidenceCallback;
	}

	function getIterator() : Generator
	{
		yield from ($this->callback)();
	}
}
