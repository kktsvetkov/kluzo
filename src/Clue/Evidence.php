<?php

namespace Kluzo\Clue;

use Kluzo\Clue\ClueInterface as Clue;
use Kluzo\Clue\FormatTrait;
use Kluzo\Clue\LabelTrait;
use Generator;

class Evidence implements Clue
{
	use FormatTrait;
	use LabelTrait;

	protected $callback;

	function __construct(callable $evidenceCallback)
	{
		$this->callback = $evidenceCallback;
	}

	function getIterator() : Generator
	{
		$evidenceCallback = $this->callback;
		yield from $evidenceCallback();
	}
}
