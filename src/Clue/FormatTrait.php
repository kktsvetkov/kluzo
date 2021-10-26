<?php

namespace Kluzo\Clue;

trait FormatTrait
{
	protected $suggestedFormat = '';

	function formatAs(string $format) : self
	{
		$this->suggestedFormat = $format;
		return $this;
	}

	function getFormat() : string
	{
		return $this->suggestedFormat;
	}

	function as(string $format = null)
	{
		return (null !== $format)
			? $this->formatAs($format)
			: $this->getFormat();
	}
}
