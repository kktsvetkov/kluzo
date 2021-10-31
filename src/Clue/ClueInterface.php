<?php

namespace Kluzo\Clue;
use IteratorAggregate;

interface ClueInterface extends IteratorAggregate
{
	/**
	* Get the format identifier for this clue
	*
	* @return string|null
	*/
	function getFormat() : ?string;

	/**
	* Get the label for this clue 
	*
	* @return string|null
	*/
	function getLabel() : ?string;
}
