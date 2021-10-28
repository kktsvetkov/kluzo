<?php

namespace Kluzo\Report\Format;

use Kluzo\Clue\ClueInterface as Clue;
use IteratorAggregate;

interface AggregateInterface Extends IteratorAggregate
{
	function getFormat(string $formatName) : ?callable;
	function addFormat(string $formatName, callable $format) : self;
	function dropFormat(string $formatName) : self;

	function formatAs(string $formatName, Clue $clue) : string;
}
