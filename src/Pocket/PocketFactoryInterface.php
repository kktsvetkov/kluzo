<?php

namespace Kluzo\Pocket;

use Kluzo\Pocket\PocketInterface as Pocket;

interface PocketFactoryInterface
{
	function createPocket() : Pocket;
}
