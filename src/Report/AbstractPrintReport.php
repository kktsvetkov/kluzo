<?php

namespace Kluzo\Report;

use Kluzo\Clue\ClueInterface as Clue;
use Kluzo\Kit\HTTP as HTTPKit;
use Kluzo\Pocket\Aggregate\AggregateInterface as PocketAggregate;
use Kluzo\Pocket\PocketInterface as Pocket;
use Kluzo\Report\Format\Aggregate as FormatAggregate;
use Kluzo\Report\Format\Standard as StandardFormat;
use Kluzo\Report\ReportInterface as CaseReport;

abstract class AbstractPrintReport implements CaseReport
{
	function sendReport(PocketAggregate $pocketAggregate)
	{
		if (HTTPKit::isOutputHTML())
		{
			$this->printReport($pocketAggregate);
		}
	}

	protected function printReport(PocketAggregate $pocketAggregate)
	{
		static $introduced = false;
		if (!$introduced)
		{
			$this->introduceJavascript( $pocketAggregate )
				->introduceCSS( $pocketAggregate );

			$introduced = true;
		}

		$this->openDisplay( $pocketAggregate );

		foreach ($pocketAggregate as $pocketName => $pocket)
		{
			$this->displayPocket($pocketName, $pocket);
		}

		$this->closeDisplay( $pocketAggregate );
	}

	abstract protected function displayPocket(string $pocketName, Pocket $pocket) : self;
	abstract protected function displayClue(Clue $clue) : self;

	abstract protected function openDisplay(PocketAggregate $pocketAggregate) : self;
	abstract protected function closeDisplay(PocketAggregate $pocketAggregate) : self;

	abstract protected function introduceJavascript(PocketAggregate $pocketAggregate) : self;
	abstract protected function introduceCSS(PocketAggregate $pocketAggregate) : self;

	protected $formatAggregate;

	function getFormats() : FormatAggregate
	{
		return $this->formatAggregate ?? (
			$this->formatAggregate = StandardFormat::loadFormats()
		);
	}
}
