<?php

namespace Kluzo\Pocket;

use Kluzo\Pocket\PocketAggregateInterface as Aggregate;
use Kluzo\Pocket\PocketInterface as Pocket;
use Kluzo\Pocket\PocketFactoryInterface as PocketFactory;
use Kluzo\Pocket\PocketFactory as DefaultPocketFactory;

use Generator;

use function array_filter;
use function strtolower;

class PocketAggregate implements Aggregate
{
	protected $pockets = array();

	function __construct(array $pockets = [], PocketFactory $emptyPocketFactory = null)
	{
		$this->pockets = array_filter($pockets, function($pocket)
		{
			return ($pocket instanceOf Pocket);
		});

		$this->setEmptyPocketFactory(
			$emptyPocketFactory ?? DefaultPocketFactory::withArrayPocket()
		);
	}

	function addPocket(string $pocketName, Pocket $pocketObject) : Aggregate
	{
		$pocketName = strtolower($pocketName);
		$this->pockets[ $pocketName ] = $pocketObject;
		return $this;
	}

	function dropPocket(string $pocketName) : Aggregate
	{
		$pocketName = strtolower($pocketName);
		unset($this->pockets[ $pocketName ]);
		return $this;
	}

	function cleanPocket(string $pocketName) : Aggregate
	{
		$pocketName = strtolower($pocketName);
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

	function setEmptyPocketFactory(PocketFactory $emptyPocketFactory) : Aggregate
	{
		$this->emptyPocketFactory = $emptyPocketFactory;
		return $this;
	}

	function createEmptyPocket() : Pocket
	{
		return $this->emptyPocketFactory->createPocket();
	}

	protected $blockedPockets = array();

	function unblockPocket(string $pocketName) : Aggregate
	{
		$pocketName = strtolower($pocketName);
		unset($this->blockedPockets[ $pocketName ]);
		return $this;
	}

	function blockPocket(string $pocketName) : Aggregate
	{
		$pocketName = strtolower($pocketName);
		$this->blockedPockets[ $pocketName ] = true;
		return $this;
	}

	function isBlocked(string $pocketName) : bool
	{
		$pocketName = strtolower($pocketName);
		return !empty($this->blockedPockets[ $pocketName ]);
	}

	function getPocket(string $pocketName) : ?Pocket
	{
		$pocketName = strtolower($pocketName);
		if ($this->isBlocked( $pocketName ))
		{
			return null;
		}

		return $this->pockets[ $pocketName ] ?? (
			$this->pockets[ $pocketName ] = $this->createEmptyPocket()
			);
	}

	function getIterator() : Generator
	{
		yield from $this->pockets;
	}
}
