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

	function miss() : self
	{
		return $this->formatAs('miss');
	}

	function text() : self
	{
		return $this->formatAs('text');
	}

	function html() : self
	{
		return $this->formatAs('html');
	}
}
