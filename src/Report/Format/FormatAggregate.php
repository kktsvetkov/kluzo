<?php

namespace Kluzo\Report\Format;

use Kluzo\Report\FormatInterface as ReportFormat;
use Kluzo\Report\FormatAggregateInterface as Aggregate;
use Generator;

use function array_filter;

class FormatAggregate implements Aggregate
{
	protected $formats = array();

	function __construct(array $formats = [])
	{
		$this->formats = array_filter($formats, function($format)
		{
			return ($format instanceOf ReportFormat);
		});
	}

	function getFormat(string $formatName) : ?ReportFormat
	{
		return $this->formats[ $formatName ] ?? null;
	}

	function setFormat(string $formatName, ReportFormat $format) : Aggregate
	{
		$this->formats[ $formatName ] = $format;
		return $this;
	}

	function getIterator() : Generator
	{
		yield from $this->formats;
	}
}
