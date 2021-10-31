<?php

namespace Kluzo\Clue;

use Kluzo\Clue\ClueInterface as Clue;
use Generator;

class Declaration implements Clue
{
	protected $declaration;

	function __construct($declaration)
	{
		$this->declaration = $declaration;
	}

	function getIterator() : Generator
	{
		yield $this->declaration;
	}

	function getFormat() : ?string
	{
		return null;
	}

	function getLabel() : ?string
	{
		return null;
	}
}
