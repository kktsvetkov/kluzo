<?php

namespace Kluzo\Clue;

use Kluzo\Clue\ClueInterface as Clue;
use Kluzo\Clue\Evidence as EvidenceClue;
use Kluzo\Clue\MetaTrait;
use Kluzo\Kit\Trace as TraceKit;
use Exception;
use Generator;

class Testimony extends Exception implements Clue
{
	use MetaTrait;

	protected $things = array();

	function __construct(...$things)
	{
		$this->things = $things;
	}

	function getTraceAsClue() : EvidenceClue
	{
		return new EvidenceClue(function()
		{
			return TraceKit::unjunk( $this->getTrace() );
		});
	}

	function getIterator() : Generator
	{
		yield from $this->things;
	}
}
