<?php

namespace Kluzo\Pocket;

use Kluzo\Pocket\PocketInterface as Pocket;
use Generator;

class DumpOnlyPocket implements Pocket
{
	protected $callback;

	function __construct(callable $callback)
	{
		$this->callback = $callback;
	}

	function put(...$things) : self
	{
		return $this;
	}

	function clean() : self
	{
		return $this;
	}

	function getIterator() : Generator
	{
		if (!$callback = $this->callback)
		{
			return;
		}

		$things = $callback();
		yield from $things;
	}
}
