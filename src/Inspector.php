<?php

namespace Kluzo;

use Kluzo\Disguise\DisguiseInterface as Disguise;
use Kluzo\Disguise\LegacyLayout as DefaultDisguise;
use Kluzo\Inspector\InspectorInterface as Investigator;
use Kluzo\Pocket\PocketInterface as Pocket;
use Kluzo\Pocket\PocketFactoryInterface as PocketFactory;
use Kluzo\Pocket\PocketFactory as DefaultPocketFactory;
use Kluzo\Kit\HTTP as HttpKit;
use Generator;

use function array_filter;

class Inspector implements Investigator
{
	protected $pockets = array();

	function __construct(array $pockets = [])
	{
		$this->pockets = array_filter($pockets, function($pocket)
		{
			return ($pocket instanceOf Pocket);
		});
	}

	function getPocket(string $pocketName) : ?Pocket
	{
		return $this->pockets[ $pocketName ] ?? null;
	}

	function addPocket(string $pocketName, Pocket $pocketObject) : Investigator
	{
		$this->pockets[ $pocketName ] = $pocketObject;
		return $this;
	}

	function dropPocket(string $pocketName) : Investigator
	{
		unset($this->pockets[ $pocketName ]);
		return $this;
	}

	function cleanPocket(string $pocketName) : Investigator
	{
		if ($pocket = $this->getPocket( $pocketName ))
		{
			$pocket->clean();
		}

		return $this;
	}

	/**
	* @var Kluzo\Pocket\PocketFactoryInterface
	*/
	protected $emptyPocketFactory;

	function setEmptyPocketFactory(PocketFactory $emptyPocketFactory) : Investigator
	{
		$this->emptyPocketFactory = $emptyPocketFactory;
		return $this;
	}

	function createEmptyPocket() : Pocket
	{
		if (!$this->emptyPocketFactory)
		{
			$this->emptyPocketFactory = DefaultPocketFactory::withIgnorePocket();
		}

		return $this->emptyPocketFactory->createPocket();
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

	protected $disabledPockets = array();

	function enablePocket(string $pocketName) : Investigator
	{
		unset($this->disabledPockets[ $pocketName ]);
		return $this;
	}

	function disablePocket(string $pocketName) : Investigator
	{
		$this->disabledPockets[ $pocketName ] = true;
		return $this;
	}

	function log(string $pocketName, ...$things) : Investigator
	{
		if (!$this->enabled)
		{
			return $this;
		}

		if ($this->disabledPockets[ $pocketName ] ?? null)
		{
			return $this;
		}

		if (!$pocket = $this->pockets[ $pocketName ] ?? null)
		{
			$pocket = $this->pockets[ $pocketName ] = $this->createEmptyPocket();
		}

		$pocket->put(...$things);
		return $this;
	}

	/**
	* @var Kluzo\Disguise\DisguiseInterface
	*/
	protected Disguise $disguise;

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
			$this->getDisguise()->display( $this );
			return true;
		}

		return false;
	}

	function getIterator() : Generator
	{
		yield from $this->pockets;
	}

	function count() : int
	{
		return count($this->pockets);
	}
}
