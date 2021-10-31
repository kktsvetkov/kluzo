<?php

namespace Kluzo\Clue;

use Kluzo\Clue\ClueInterface as Clue;
use Kluzo\Clue\LabeledClueTrait;
use Kluzo\Clue\MetaTrait;
use Generator;

class Evidence implements Clue
{
	use MetaTrait;
	use LabeledClueTrait;

	protected $callback;

	function __construct(callable $evidenceCallback)
	{
		$this->callback = $evidenceCallback;
	}

	function getIterator() : Generator
	{
		yield from ($this->callback)();
	}
}
