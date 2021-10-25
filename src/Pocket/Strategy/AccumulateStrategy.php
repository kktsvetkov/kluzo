<?php

namespace Kluzo\Pocket\Strategy;

use Kluzo\Clue\Testimony as TestimonyClue;
use Kluzo\Pocket\ArrayPocket as DefaultPocket;
use Kluzo\Pocket\PocketInterface as Pocket;
use Kluzo\Pocket\Aggregate\AggregateInterface as PocketAggregate;
use Kluzo\Pocket\Strategy\StrategyInterface as PocketStrategy;

class AccumulateStrategy implements PocketStrategy
{
	protected $defaultPocketName = 'Log';
	protected $defaultPocket;

	function __construct(string $defaultPocketName = null, Pocket $defaultPocket = null)
	{
		$this->defaultPocketName($defaultPocketName);
		$this->defaultPocket = $defaultPocket;
	}

	function defaultPocketName(string $defaultPocketName = null) : string
	{
		if (null !== $defaultPocketName)
		{
			$this->defaultPocketName = $defaultPocketName;
		}

		return $this->defaultPocketName;
	}

	protected $knownPockets = array();

	function findPocket(string $pocketName, PocketAggregate $pocketAggregate) : ?Pocket
	{
		if ($pocket = $pocketAggregate->getPocket($pocketName))
		{
			return $pocket;
		}

		$defaultPocket = $pocketAggregate->getPocket($this->defaultPocketName);
		if (!$defaultPocket)
		{
			$defaultPocket = $this->defaultPocket ?? new DefaultPocket;
			$pocketAggregate->addPocket(
				$this->defaultPocketName,
				$defaultPocket->with('default.pocket')
			);
		}

		if (empty($this->knownPockets[ $pocketName ]))
		{
			$this->knownPockets[ $pocketName ] = true;

			$clue = new TestimonyClue(
				"Collecting clues for as pocket '{$pocketName}'"
				);
			$defaultPocket->put( $clue->setLabel('New Pocket') );
		}

		return $defaultPocket;
	}
}
