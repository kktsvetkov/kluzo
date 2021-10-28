<?php

namespace Kluzo\Report\Format;

use Kluzo\Clue\ClueInterface as Clue;
use Kluzo\Report\Format\AggregateInterface as FormatAggregate;
use Generator;

use function array_filter;
use function is_callable;
use function strtolower;

class Aggregate implements FormatAggregate
{
	protected $formats = array();

	function __construct(array $formats = [])
	{
		$this->formats = array_filter($formats, function($format)
		{
			return is_callable($format);
		});
	}

	function addFormat(string $formatName, callable $format) : FormatAggregate
	{
		$formatName = strtolower($formatName);
		$this->formats[ $formatName ] = $format;

		return $this;
	}

	function dropFormat(string $formatName) : FormatAggregate
	{
		$formatName = strtolower($formatName);
		unset($this->formats[ $formatName ]);

		return $this;
	}

	function getFormat(string $formatName) : ?callable
	{
		$formatName = strtolower($formatName);
		return $this->formats[ $formatName ] ?? null;
	}

	function formatAs(string $formatName, Clue $clue) : string
	{
		$callback = $this->getFormat($formatName) ?? $this->getFormat('');
		return (string) $callback($clue);
	}

	function getIterator() : Generator
	{
		yield from $this->formats;
	}
}
