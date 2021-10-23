<?php

namespace Kluzo\Report;

use Kluzo\Clue\ClueInterface as Clue;
use Kluzo\Pocket\PocketInterface as Pocket;
use Kluzo\Pocket\PocketAggregateInterface as PocketAggregate;
use Kluzo\Report\ReportInterface as CaseReport;

use Kluzo\Kit\HTTP as HTTPKit;

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
}
