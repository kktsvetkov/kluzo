<?php

namespace Kluzo\Pocket;

use Kluzo\Pocket\PocketInterface as Pocket;
use Generator;

class ArrayPocket implements Pocket
{
	protected $things = array();

	function __construct(...$things)
	{
		if ($things)
		{
			$this->put(...$things);
		}
	}

	function put(...$things) : self
	{
		foreach ($things as $thing)
		{
			$this->things[] = $thing;
		}

		return $this;
	}

	function clean() : self
	{
		$this->things = array();
		return $this;
	}

	function getIterator() : Generator
	{
		yield from $this->things;
	}
}
