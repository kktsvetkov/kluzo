<?php

namespace Kluzo\Pocket;

use Kluzo\Pocket\PocketInterface as Pocket;
use ArrayIterator;

class IgnorePocket implements Pocket
{
	function put(...$things) : Pocket
	{
		return $this;
	}

	function clean() : Pocket
	{
		return $this;
	}

	function getIterator() : ArrayIterator
	{
		return new ArrayIterator([]);
	}
}
