<?php

namespace Kluzo\Clue;
use IteratorAggregate;

interface ClueInterface extends IteratorAggregate
{
	function getLabel() : string;

	function getMeta(string $metaName) : ?string;
}
