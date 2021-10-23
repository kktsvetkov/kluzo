<?php

namespace Kluzo\Report\Format;

use Kluzo\Report\FormatInterface as ReportFormat;
use IteratorAggregate;

interface FormatAggregateInterface extends IteratorAggregate
{
	function getFormat(string $formatName) : ReportFormat;
	function setFormat(string $formatName, ReportFormat $format) : self;
}
