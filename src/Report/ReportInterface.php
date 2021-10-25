<?php

namespace Kluzo\Report;

use Kluzo\Pocket\Aggregate\AggregateInterface as PocketAggregate;

interface ReportInterface
{
	function sendReport(PocketAggregate $pocketAggregate);
}
