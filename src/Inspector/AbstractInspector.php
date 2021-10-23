<?php

namespace Kluzo\Inspector;

use Kluzo\Clue\ClueInterface as Clue;

use Kluzo\Pocket\PocketAggregateInterface as PocketAggregate;
use Kluzo\Pocket\PocketAggregate as DefaultPocketAggregate;

use Kluzo\Report\ReportInterface as CaseReport;
use Kluzo\Report\LegacyLayout as DefaultReport;

abstract class AbstractInspector
{
	protected $pocketAggregate;

	function __construct(PocketAggregate $pocketAggregate = null)
	{
		$this->pocketAggregate = $pocketAggregate
			?? new DefaultPocketAggregate;
	}

	function getPockets() : PocketAggregate
	{
		return $this->pocketAggregate;
	}

	protected $caseSuspended = false;

	function suspendCase() : self
	{
		$this->caseSuspended = true;
		return $this;
	}

	function resumeCase() : self
	{
		$this->caseSuspended = false;
		return $this;
	}

	function isCaseSuspended() : bool
	{
		return $this->caseSuspended;
	}

	function unblockPocket(string $pocketName) : self
	{
		$this->pocketAggregate->unblockPocket( $pocketName );
		return $this;
	}

	function blockPocket(string $pocketName) : self
	{
		$this->pocketAggregate->blockPocket( $pocketName );
		return $this;
	}

	function cleanPocket(string $pocketName) : self
	{
		$this->pocketAggregate->cleanPocket( $pocketName );
		return $this;
	}

	protected $reportCallback;

	function setCreateReportCallback(callable $reportCallback) : self
	{
		$this->reportCallback = $reportCallback;
		return $this;
	}

	protected function createCaseReport(PocketAggregate $pocketAggregate) : CaseReport
	{
		if ($reportCallback = $this->reportCallback)
		{
			return $reportCallback( $pockedAggregate );
		}

		return new DefaultReport( $pocketAggregate );
	}

	protected $caseClosed = false;

	function closeCase()
	{
		$this->caseClosed = true;
		$this->createCaseReport( $this->pocketAggregate )->sendReport();
	}

	function __destruct()
	{
		if ($this->caseClosed)
		{
			return;
		}

		if ($this->caseSuspended)
		{
			return;
		}

		$this->closeCase();
	}

	abstract function log(string $pocketName, ...$things) : Clue;
}
