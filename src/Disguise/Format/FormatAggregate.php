<?php

namespace Kluzo\Disguise\Format;

use Kluzo\Disguise\FormatInterface as DisguiseFormat;
use Kluzo\Disguise\FormatAggregateInterface as Aggregate;
use Generator;

use function array_filter;

class FormatAggregate implements Aggregate
{
	protected $formats = array();

	function __construct(array $formats = [])
	{
		$this->formats = array_filter($formats, function($format)
		{
			return ($format instanceOf DisguiseFormat);
		});
	}

	function getFormat(string $formatName) : ?DisguiseFormat
	{
		return $this->formats[ $formatName ] ?? null;
	}

	function setFormat(string $formatName, DisguiseFormat $format) : Aggregate
	{
		$this->formats[ $formatName ] = $format;
		return $this;
	}

	function getIterator() : Generator
	{
		yield from $this->formats;
	}
}
