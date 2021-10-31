<?php

namespace Kluzo\Clue;
use IteratorAggregate;

interface ClueInterface extends IteratorAggregate
{
	function getFormat() : ?string;

	function getLabel() : ?string;
}
