<?php

namespace Kluzo\Clue;

use Kluzo\Clue\ClueInterface as Clue;
use Generator;

/**
* Declaration Clue
*
* Declaration clues take only one variable and have no format, no label
* and no trace as they are only used internally when needing to pass
* information in clue form
*/
class Declaration implements Clue
{
	/**
	* @var mixed declaration clue variable
	*/
	protected $declaration;

	/**
	* Constructor
	*
	* @param mixed $declaration
	*/
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
