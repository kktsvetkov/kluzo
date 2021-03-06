<?php

namespace Kluzo\Pocket;

use Kluzo\Clue\ClueInterface as Clue;
use Kluzo\Disguise as InspectorDisguise;
use Kluzo\Kit\Pocket as PocketKit;
use Kluzo\Pocket\Aggregate\AggregateInterface as PocketAggregate;
use Kluzo\Pocket\Dismiss\AuthorityInterface as DismissAuthority;
use Kluzo\Report\ReportInterface as CaseReport;
use Kluzo\Report\AbstractPrintReport as PrintReport;
use Generator;

use function htmlentities;

final class Dismiss implements CaseReport, Clue
{
	static function setup(DismissAuthority $authority) : self
	{
		$inspector = InspectorDisguise::getInspector();
		$currentReport = $inspector->getReport();

		if ($currentReport instanceOf self)
		{
			return $currentReport;
		}

		// replace current report with the "dismiss" report
		//
		$dismissReport = new self( $authority, $currentReport );
		$inspector->setReport( $dismissReport );

		// preemptively block the mismissed pockets
		//
		$pocketAggregate = $inspector->getPockets();
		foreach ($authority as $pocketName)
		{
			$pocketAggregate->blockPocket( $pocketName );
		}

		// introduce new "dismiss" format as alias of "html"
		//
		$formats = $currentReport->getFormats();
		$formats->addFormat('dismiss', (static function(Clue $clue) use ($formats)
		{
			return $formats->formatAs('html', $clue);
		}));

		return $dismissReport;
	}

	protected $dismissAuthority;

	protected $caseReport;

	function __construct(DismissAuthority $authority, CaseReport $report)
	{
		$this->dismissAuthority = $authority;
		$this->caseReport = $report;
	}

	protected $pocketNames = array();

	function sendReport(PocketAggregate $pocketAggregate)
	{
		if (!$this->caseReport instanceOf PrintReport)
		{
			return;
		}

		// attach the settings pocket
		//
		PocketKit::getSettingsPocket($pocketAggregate)->put($this);

		// collect all of the pocket names
		//
		$this->pocketNames = array();
		foreach ($pocketAggregate as $pocketName => $pocket)
		{
			$this->pocketNames[ $pocketName ] = true;
		}

		// before rendering the report, remove the dismissed pockets
		//
		foreach ($this->dismissAuthority as $pocketName)
		{
			$this->pocketNames[ $pocketName ] = false;
			$pocketAggregate->dropPocket( $pocketName );
		}

		return $this->caseReport->sendReport( $pocketAggregate );
	}

	function getIterator() : Generator
	{
		yield $this->dismissAuthority->getHtml( $this->pocketNames );
	}

	function getLabel() : string
	{
		return 'Dismissed Pockets';
	}

	function getFormat() : ?string
	{
		return 'dismiss';
	}
}
