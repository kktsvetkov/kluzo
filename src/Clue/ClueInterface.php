<?php

namespace Kluzo\Clue;
use IteratorAggregate;

interface ClueInterface extends IteratorAggregate
{
	function getMeta(string $metaName) : ?string;
}
