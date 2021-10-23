<?php

namespace Kluzo\Report;

use Kluzo\Pocket\PocketAggregateInterface as PocketAggregate;

interface ReportInterface
{
	function sendReport(PocketAggregate $pocketAggregate);
}
