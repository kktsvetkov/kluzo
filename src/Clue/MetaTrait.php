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
}
