<?php

namespace Kluzo\Kit;

use Kluzo\Clue\Testimony as TestimonyClue;
use Kluzo\Disguise as InspectorDisguise;
use Kluzo\Pocket\ArrayPocket;
use Kluzo\Pocket\PocketInterface as Pocket;

use const E_USER_WARNING;

use function trigger_error;

class Blooper
{
	private static function getBlooperPocket() : ?Pocket
	{
		$pocketAggregate = InspectorDisguise::getInspector()->getPockets();
		if (!$blooperPocket = $pocketAggregate->getPocket('bloopers'))
		{
			$pocketAggregate->addPocket(
				'bloopers',
				$blooperPocket = new ArrayPocket
			);
		}

		return $blooperPocket;
	}

	static function log(string $blooper)
	{
		if (!$blooperPocket = self::getBlooperPocket())
		{
			return trigger_error($blooper, E_USER_WARNING);
		}

		$blooperPocket->put(
			(new TestimonyClue($blooper))->formatAs('blooper')
			);
	}
}
