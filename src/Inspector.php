<?php

namespace Kluzo;

use Kluzo\Pocket\PocketInterface as Pocket;
use Kluzo\Pocket\PocketFactoryInterface as PocketFactory;
use Kluzo\Pocket\PocketFactory as DefaultPocketFactory;
use IteratorAggregate;
use Generator;

use function array_filter;

class Inspector implements IteratorAggregate
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

	function addPocket(string $pocketName, Pocket $pocketObject) : self
	{
		$this->pockets[ $pocketName ] = $pocketObject;
		return $this;
	}

	function dropPocket(string $pocketName) : self
	{
		unset($this->pockets[ $pocketName ]);
		return $this;
	}

	function cleanPocket(string $pocketName) : self
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

	function setEmptyPocketFactory(PocketFactory $emptyPocketFactory) : self
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

	function enableInspector() : self
	{
		$this->enabled = true;
		return $this;
	}

	function disableInspector() : self
	{
		$this->enabled = false;
		return $this;
	}

	function isEnabled() : bool
	{
		return $this->enabled;
	}

	protected $disabledPockets = array();

	function enablePocket(string $pocketName) : self
	{
		unset($this->disabledPockets[ $pocketName ]);
		return $this;
	}

	function disablePocket(string $pocketName) : self
	{
		$this->disabledPockets[ $pocketName ] = true;
		return $this;
	}

	function log(string $pocketName, ...$things) : self
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

	function getIterator() : Generator
	{
		yield from $this->pockets;
	}
}
