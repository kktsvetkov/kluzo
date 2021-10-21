<?php

namespace Kluzo\Disguise\Format;

use Kluzo\Clue\ClueInterface as Clue;
use Kluzo\Disguise\Format\FormatInterface as DisguiseFormat;

use function print_r;

class DefaultFormat implements DisguiseFormat
{
	function format($thing) : string
	{
		return print_r($thing, true);
	}
}
