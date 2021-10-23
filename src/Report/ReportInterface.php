<?php

namespace Kluzo\Report;

use Kluzo\Pocket\PocketAggregateInterface as PocketAggregate;

interface ReportInterface
{
	function __construct(PocketAggregate $pocketAggregate);
	function sendReport();
}
