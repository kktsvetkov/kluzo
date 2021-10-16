<?php

namespace Kluzo\Inspector;

use Kluzo\Pocket\PocketInterface as Pocket;
use Countable;
use IteratorAggregate;

interface InspectorInterface extends IteratorAggregate, Countable
{
	function getPocket(string $pocketName) : ?Pocket;
	function addPocket(string $pocketName, Pocket $pocketObject) : self;
	function dropPocket(string $pocketName) : self;
	function cleanPocket(string $pocketName) : self;

	function createEmptyPocket() : Pocket;

	function enableInspector() : self;
	function disableInspector() : self;
	function isEnabled() : bool;

	function enablePocket(string $pocketName) : self;
	function disablePocket(string $pocketName) : self;

	function log(string $pocketName, ...$things) : self;
	function display();
}
