<?php

namespace Kluzo\Pocket;

use IteratorAggregate;

interface PocketInterface extends IteratorAggregate
{
	function put(...$things) : self;

	function clean() : self;
}
