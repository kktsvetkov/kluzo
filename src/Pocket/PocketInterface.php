<?php

namespace Kluzo\Pocket;

use Kluzo\Clue\ClueInterface as Clue;
use IteratorAggregate;

interface PocketInterface extends IteratorAggregate
{
	function put(Clue $clue) : self;

	function clean() : self;
}
