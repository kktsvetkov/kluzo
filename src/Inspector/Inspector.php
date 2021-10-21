<?php

namespace Kluzo\Inspector;

use Kluzo\Clue\ClueInterface as Clue;
use Kluzo\Clue\Ignore as IgnoreClue;
use Kluzo\Clue\Testimony as TestimonyClue;

use Kluzo\Disguise\DisguiseInterface as Disguise;
use Kluzo\Disguise\LegacyLayout as DefaultDisguise;

use Kluzo\Inspector\InspectorInterface;

use Kluzo\Pocket\PocketInterface as Pocket;
use Kluzo\Pocket\PocketAggregateInterface as PocketAggregate;
use Kluzo\Pocket\PocketAggregate as DefaultPocketAggregate;

use Kluzo\Kit\HTTP as HttpKit;

class Inspector implements InspectorInterface
{
	protected $pocketAggregate;

	function __construct(
		PocketAggregate $pocketAggregate = null
		)
	{
		$this->pocketAggregate = $pocketAggregate
			?? new DefaultPocketAggregate;
	}

	function getPockets() : PocketAggregate
	{
		return $this->pocketAggregate;
	}

	protected $enabled = true;

	function enableInspector() : Inspector
	{
		$this->enabled = true;
		return $this;
	}

	function disableInspector() : Inspector
	{
		$this->enabled = false;
		return $this;
	}

	function isEnabled() : bool
	{
		return $this->enabled;
	}

	function unblockPocket(string $pocketName) : Inspector
	{
		$this->pocketAggregate->unblockPocket( $pocketName );
		return $this;
	}

	function blockPocket(string $pocketName) : Inspector
	{
		$this->pocketAggregate->blockPocket( $pocketName );
		return $this;
	}

	function cleanPocket(string $pocketName) : Inspector
	{
		$this->pocketAggregate->cleanPocket( $pocketName );
		return $this;
	}

	function log(string $pocketName, ...$things) : Clue
	{
		if (!$this->enabled)
		{
			return new IgnoreClue;
		}

		if (!$pocket = $this->pocketAggregate->getPocket( $pocketName ))
		{
			return new IgnoreClue;
		}

		$pocket->put( $clue = new TestimonyClue(...$things) );
		return $clue;
	}

	/**
	* @var Kluzo\Disguise\DisguiseInterface
	*/
	protected $disguise;

	function setDisguise(Disguise $disguise) : Inspector
	{
		$this->disguise = $disguise;
		return $this;
	}

	function getDisguise() : Disguise
	{
		return $this->disguise ?? (
			$this->disguise = new DefaultDisguise
			);
	}

	function display()
	{
		if (HttpKit::isOutputHTML())
		{
			$this->getDisguise()->display( $this->pocketAggregate );
			return true;
		}

		return false;
	}
}
