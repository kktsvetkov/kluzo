<?php

namespace Kluzo\Clue;

use Kluzo\Clue\MetaTrait;

trait FormatTrait
{
	use MetaTrait;

	function formatAs(string $format) : self
	{
		return $this->setMeta('format', $format);
	}

	function getFormat() : string
	{
		return $this->getMeta('format') ?? '';
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
