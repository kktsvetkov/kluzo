<?php

namespace Kluzo\Report;

use Kluzo\Pocket\Aggregate\AggregateInterface as PocketAggregate;
use Kluzo\Report\ReportInterface as CaseReport;

class NonVocal implements CaseReport
{
	function sendReport(PocketAggregate $pocketAggregate)
	{
		// do nothing;
	}
}
