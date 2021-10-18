<?php

namespace Kluzo;

use Kluzo\Disguise\DisguiseInterface as Disguise;
use Kluzo\Disguise\LegacyLayout as DefaultDisguise;
use Kluzo\Inspector\InspectorInterface as Investigator;
use Kluzo\Pocket\PocketInterface as Pocket;
use Kluzo\Pocket\PocketAggregateInterface as PocketAggregate;
use Kluzo\Pocket\PocketAggregate as DefaultPocketAggregate;
use Kluzo\Kit\HTTP as HttpKit;
use Kluzo\Kit\Trace as TraceKit;

class Inspector implements Investigator
{
	protected $pocketAggregate;

	function __construct(PocketAggregate $pocketAggregate = null)
	{
		$this->pocketAggregate = $pocketAggregate ?? new DefaultPocketAggregate;
	}

	function getPockets() : PocketAggregate
	{
		return $this->pocketAggregate;
	}

	protected $enabled = true;

	function enableInspector() : Investigator
	{
		$this->enabled = true;
		return $this;
	}

	function disableInspector() : Investigator
	{
		$this->enabled = false;
		return $this;
	}

	function isEnabled() : bool
	{
		return $this->enabled;
	}

	function unblockPocket(string $pocketName) : Investigator
	{
		$this->pocketAggregate->unblockPocket( $pocketName );
		return $this;
	}

	function blockPocket(string $pocketName) : Investigator
	{
		$this->pocketAggregate->blockPocket( $pocketName );
		return $this;
	}

	function cleanPocket(string $pocketName) : Investigator
	{
		$this->pocketAggregate->cleanPocket( $pocketName );
		return $this;
	}

	function log(string $pocketName, ...$things) : Investigator
	{
		if ($this->enabled)
		{
			if ($pocket = $this->pocketAggregate->getPocket( $pocketName ))
			{
				$pocket->put(...$things);
			}
		}

		return $this;
	}

	function trace(string $pocketName, ...$things) : Investigator
	{
		$things[] = TraceKit::getTraceBack();
		return $this->log($pocketName, ...$things);
	}

	/**
	* @var Kluzo\Disguise\DisguiseInterface
	*/
	protected $disguise;

	function setDisguise(Disguise $disguise) : Investigator
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
