<?php

namespace Kluzo\Kit;

use Kluzo\Disguise as InspectorDisguise;
use Kluzo\Kit\Pocket as PocketKit;
use const E_USER_WARNING;
use function trigger_error;

class Blooper
{
	static function log(string $blooper)
	{
		$inspector = InspectorDisguise::getInspector();
		$pocketAggregate = $inspector->getPockets();

		if (!$blooperPocket = PocketKit::getInternalPocket('bloopers', $pocketAggregate))
		{
			return trigger_error($blooper, E_USER_WARNING);
		}

		$inspector->log('bloopers', $blooper)->formatAs('blooper');
	}
}
