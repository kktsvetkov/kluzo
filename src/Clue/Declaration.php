<?php

namespace Kluzo\Clue;

use Kluzo\Clue\ClueInterface as Clue;
use Generator;

class Declaration implements Clue
{
	function getLabel() : string
	{
		return '';
	}

	function getMeta(string $metaName) : ?string
	{
		return null;
	}

	protected $declaration;

	function __construct($declaration)
	{
		$this->declaration = $declaration;
	}

	function getIterator() : Generator
	{
		yield $this->declaration;
	}
}
