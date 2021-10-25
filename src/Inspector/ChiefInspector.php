<?php

namespace Kluzo\Inspector;

use Kluzo\Clue\Evidence as EvidenceClue;
use Kluzo\Inspector\DetectiveInspector;
use Kluzo\Pocket\Aggregate\AggregateInterface as PocketAggregate;
use Kluzo\Pocket\ArrayPocket;
use Kluzo\Pocket\LockedPocket;
use Kluzo\Report\ReportInterface as CaseReport;

class ChiefInspector extends DetectiveInspector
{
	function __construct(
		PocketAggregate $pocketAggregate = null,
		CaseReport $caseReport = null)
	{
		parent::__construct($pocketAggregate, $caseReport);

		$this->getPockets()->addPocket('Request', (new ArrayPocket)
			->with('no.count', 'no.index')
			->put( (new EvidenceClue(
					static function()
					{
						return $_GET;
					})
				)->setLabel('$_GET')
			)
			->put( (new EvidenceClue(
					static function()
					{
						return $_POST;
					})
				)->setLabel('$_POST')
			)
			->put( (new EvidenceClue(
					static function()
					{
						return $_COOKIE;
					})
				)->setLabel('$_COOKIE')
			));

		$this->getPockets()->addPocket('Session', (new ArrayPocket)
			->with('no.count', 'no.index')
			->put( (new EvidenceClue(
					static function()
					{
						return $_SESSION ?? [];
					})
				)->setLabel('$_SESSION')
			));

		$this->getPockets()->addPocket('Server', (new ArrayPocket)
			->with('no.count', 'no.index')
			->put( (new EvidenceClue(
					static function()
					{
						return $_SERVER ?? [];
					})
				)->setLabel('$_SERVER')
			));

		$this->getPockets()->addPocket('Files', new LockedPocket(
			(new EvidenceClue(static function()
			{
				return get_included_files();
			}))->setLabel('get_included_files()'),
		));
	}
}
