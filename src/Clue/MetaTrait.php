<?php

namespace Kluzo\Clue;

use function strtolower;

trait MetaTrait
{
	protected $meta = array();

	function getMeta(string $metaName) : ?string
	{
		$metaName = strtolower( $metaName );
		return $this->meta[ $metaName ] ?? null;
	}

	function setMeta(string $metaName, string $metaValue) : self
	{
		$metaName = strtolower( $metaName );
		$this->meta[ $metaName ] = $metaValue;
		return $this;
	}

	function setLabel(string $label) : self
	{
		return $this->setMeta('label', $label);
	}

	function getLabel() : ?string
	{
		return $this->getMeta('label');
	}

	function label(string $label = null)
	{
		return (null !== $label)
			? $this->setLabel($label)
			: $this->getLabel();
	}

	function formatAs(string $format) : self
	{
		return $this->setMeta('format', $format);
	}

	function getFormat() : ?string
	{
		return $this->getMeta('format');
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
