<?php

namespace Kluzo\Report\Format;

use Kluzo\Clue\ClueInterface as Clue;
use Kluzo\Report\Format\FormatInterface as ReportFormat;

use function print_r;

class DefaultFormat implements ReportFormat
{
	function format($thing) : string
	{
		return print_r($thing, true);
	}
}
