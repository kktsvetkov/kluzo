<?php

namespace Kluzo\Clue;

use Kluzo\Clue\ClueInterface as Clue;

interface ClueFactoryInterface
{
	function createClue(...$things) : Clue;
}
