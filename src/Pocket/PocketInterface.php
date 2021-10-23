<?php

namespace Kluzo\Pocket;

use Kluzo\Clue\ClueInterface as Clue;
use IteratorAggregate;
use Countable;

interface PocketInterface extends IteratorAggregate, Countable
{
	function put(Clue $clue) : self;

	function clean() : self;
}
