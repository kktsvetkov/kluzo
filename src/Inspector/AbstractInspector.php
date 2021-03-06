<?php

namespace Kluzo\Inspector;

use Kluzo\Clue\ClueInterface as Clue;
use Kluzo\Pocket\Aggregate\AggregateInterface as PocketAggregate;
use Kluzo\Pocket\Aggregate\DefaultAggregate as DefaultPocketAggregate;
use Kluzo\Report\ReportInterface as CaseReport;
use Kluzo\Report\LegacyLayout as DefaultReport;

abstract class AbstractInspector
{
	protected $pocketAggregate;
	protected $caseReport;

	function __construct(
		PocketAggregate $pocketAggregate = null,
		CaseReport $caseReport = null
		)
	{
		$this->caseReport = $caseReport ?? new DefaultReport;
		$this->pocketAggregate = $pocketAggregate ?? new DefaultPocketAggregate;
	}

	function getPockets() : PocketAggregate
	{
		return $this->pocketAggregate;
	}

	function getReport() : CaseReport
	{
		return $this->caseReport;
	}

	function setReport(CaseReport $caseReport) : self
	{
		if (!$this->caseClosed)
		{
			$this->caseReport = $caseReport;
		}

		return $this;
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

	function isCaseActive() : bool
	{
		return !$this->caseSuspended;
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

	protected $caseClosed = false;

	function closeCase() : self
	{
		$this->caseClosed = true;
		$this->caseReport->sendReport( $this->pocketAggregate );
		return $this;
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
