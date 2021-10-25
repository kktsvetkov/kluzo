<?php

namespace Kluzo\Report\Format;

use Kluzo\Clue\ClueInterface as Clue;

interface FormatInterface
{
	function format(Clue $clue) : string;
}
