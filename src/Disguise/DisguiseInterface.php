<?php

namespace Kluzo\Disguise;

use Kluzo\Pocket\PocketAggregateInterface as PocketAggregate;

interface DisguiseInterface
{
	function display(PocketAggregate $aggregate);
}
