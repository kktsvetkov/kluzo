<?php

namespace Kluzo\Kit;

use Kluzo\Pocket\PocketInterface;
use Kluzo\Pocket\Aggregate\AggregateInterface as PocketAggregate;
use Kluzo\Pocket\ArrayPocket;

class Pocket
{
	static function getInternalPocket(
		string $pocketName,
		PocketAggregate $aggregate) : PocketInterface
	{
		$internalPocket = $aggregate->getPocket( $pocketName );

		if (!$internalPocket)
		{
			$aggregate->addPocket(
				$pocketName,
				($internalPocket = new ArrayPocket)->with('internal')
			);
		}

		return $internalPocket;
	}

	static function getSettingsPocket(PocketAggregate $aggregate) : PocketInterface
	{
		return static::getInternalPocket('Settings', $aggregate)
			->with('no.index', 'no.count');
	}
}
