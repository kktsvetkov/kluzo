<?php

namespace Kluzo\Clue;

use Kluzo\Clue\ClueInterface as Clue;
use Kluzo\Clue\Declaration as DeclarationClue;
use Kluzo\Clue\LabeledClueTrait;
use Kluzo\Clue\MetaTrait;
use Kluzo\Kit\Trace as TraceKit;
use Exception;
use Generator;

class Testimony extends Exception implements Clue
{
	use MetaTrait;
	use LabeledClueTrait;

	protected $things = array();

	function __construct(...$things)
	{
		$this->things = $things;
	}

	function getTraceAsClue() : DeclarationClue
	{
		return new DeclarationClue(
			TraceKit::unjunk( $this->getTrace() )
			);
	}

	function getIterator() : Generator
	{
		yield from $this->things;
	}
}
