<?php

namespace Kluzo\Pocket\Aggregate;

use Kluzo\Pocket\Aggregate\AggregateInterface as PocketAggregate;
use Kluzo\Pocket\PocketInterface as Pocket;
use Generator;

use function array_filter;
use function strtolower;

class DefaultAggregate implements PocketAggregate
{
	protected $pockets = array();

	function __construct(array $pockets = [])
	{
		$this->pockets = array_filter($pockets, function($pocket)
		{
			return ($pocket instanceOf Pocket);
		});
	}

	function addPocket(string $pocketName, Pocket $pocketObject) : PocketAggregate
	{
		$pocketName = strtolower($pocketName);
		$this->pockets[ $pocketName ] = $pocketObject;

		return $this;
	}

	function dropPocket(string $pocketName) : PocketAggregate
	{
		$pocketName = strtolower($pocketName);
		unset($this->pockets[ $pocketName ]);

		return $this;
	}

	function cleanPocket(string $pocketName) : PocketAggregate
	{
		$pocketName = strtolower($pocketName);
		if ($pocket = $this->getPocket( $pocketName ))
		{
			$pocket->clean();
		}

		return $this;
	}

	protected $blockedPockets = array();

	function unblockPocket(string $pocketName) : PocketAggregate
	{
		$pocketName = strtolower($pocketName);
		unset($this->blockedPockets[ $pocketName ]);
		return $this;
	}

	function blockPocket(string $pocketName) : PocketAggregate
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

		return $this->pockets[ $pocketName ] ?? null;
	}

	function getIterator() : Generator
	{
		yield from $this->pockets;
	}
}
