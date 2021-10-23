<?php

namespace Kluzo\Report;

use Kluzo\Pocket\PocketInterface as Pocket;
use Kluzo\Pocket\PocketAggregateInterface as PocketAggregate;
use Kluzo\Report\ReportInterface as CaseReport;

use Kluzo\Kit\HTTP as HTTPKit;

abstract class AbstractPrintReport implements CaseReport
{
	protected $pocketAggregate;

	function __construct(PocketAggregate $pocketAggregate)
	{
		$this->pocketAggregate = $pocketAggregate;
	}

	function sendReport()
	{
		if (HTTPKit::isOutputHTML())
		{
			$this->printReport($this->pocketAggregate);
		}
	}

	protected function printReport(PocketAggregate $pocketAggregate)
	{
		static $introduced = false;
		if (!$introduced)
		{
			$this->introduceJavascript( $pocketAggregate );
			$this->introduceCSS( $pocketAggregate );

			$introduced = true;
		}

		$this->openDisplay( $pocketAggregate );
		$this->displayPockets( $pocketAggregate );
		$this->closeDisplay( $pocketAggregate );
	}

	protected function displayPockets(PocketAggregate $pocketAggregate) : self
	{
		foreach ($pocketAggregate as $pocketName => $pocket)
		{
			$formats = [$pocketName];
			if ($pocket instanceOf PocketWithSuggestedFormat)
			{
				$formats[] = $pocket->suggestFormat();
			}

			$this->displayPocket($pocketName, $pocket, $formats);
		}

		return $this;
	}

	abstract protected function displayPocket(string $pocketName, Pocket $pocket, array $formats) : self;

	abstract protected function openDisplay(PocketAggregate $pocketAggregate) : self;
	abstract protected function closeDisplay(PocketAggregate $pocketAggregate) : self;

	abstract protected function introduceJavascript(PocketAggregate $pocketAggregate) : self;
	abstract protected function introduceCSS(PocketAggregate $pocketAggregate) : self;
}
