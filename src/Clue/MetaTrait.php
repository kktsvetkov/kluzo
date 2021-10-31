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
		$this->meta[ 'label' ] = $label;
		return $this;
	}

	function getLabel() : string
	{
		return $this->meta[ 'label' ] ?? '';
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
