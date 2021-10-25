<?php

namespace Kluzo\Pocket\Aggregate;

use Kluzo\Pocket\PocketInterface as Pocket;
use IteratorAggregate;

interface AggregateInterface Extends IteratorAggregate
{
	function getPocket(string $pocketName) : ?Pocket;
	function addPocket(string $pocketName, Pocket $pocketObject) : self;
	function dropPocket(string $pocketName) : self;
	function cleanPocket(string $pocketName) : self;

	function blockPocket(string $pocketName) : self;
	function unblockPocket(string $pocketName) : self;
	function isBlocked(string $pocketName) : bool;
}
