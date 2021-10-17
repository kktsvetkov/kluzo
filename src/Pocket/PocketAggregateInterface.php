<?php

namespace Kluzo\Pocket;

use Kluzo\Pocket\PocketInterface as Pocket;
use IteratorAggregate;

interface PocketAggregateInterface Extends IteratorAggregate
{
	function getPocket(string $pocketName) : ?Pocket;
	function addPocket(string $pocketName, Pocket $pocketObject) : self;
	function dropPocket(string $pocketName) : self;
	function cleanPocket(string $pocketName) : self;

	function enablePocket(string $pocketName) : self;
	function disablePocket(string $pocketName) : self;
}
