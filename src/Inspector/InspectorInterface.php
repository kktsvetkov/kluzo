<?php

namespace Kluzo\Inspector;

use Kluzo\Pocket\PocketInterface as Pocket;
use Kluzo\Pocket\PocketAggregateInterface as PocketAggregate;

interface InspectorInterface
{
	function getPockets() : PocketAggregate;

	function enableInspector() : self;
	function disableInspector() : self;
	function isEnabled() : bool;

	function log(string $pocketName, ...$things) : self;
	function display();
}
