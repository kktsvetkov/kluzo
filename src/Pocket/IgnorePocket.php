<?php

namespace Kluzo\Pocket;

use Kluzo\Pocket\PocketInterface as Pocket;
use ArrayIterator;

class IgnorePocket implements Pocket
{
	function put(...$things) : self
	{
		return $this;
	}

	function clean() : self
	{
		return $this;
	}

	function getIterator() : ArrayIterator
	{
		return new ArrayIterator([]);
	}
}
