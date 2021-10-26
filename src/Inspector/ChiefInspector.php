<?php

namespace Kluzo\Inspector;

use Kluzo\Clue\Evidence as EvidenceClue;
use Kluzo\Inspector\DetectiveInspector;
use Kluzo\Pocket\Aggregate\AggregateInterface as PocketAggregate;
use Kluzo\Pocket\ArrayPocket;
use Kluzo\Pocket\LockedPocket;
use Kluzo\Pocket\ShallowPocket;
use Kluzo\Report\ReportInterface as CaseReport;

class ChiefInspector extends DetectiveInspector
{
	function __construct(
		PocketAggregate $pocketAggregate = null,
		CaseReport $caseReport = null)
	{
		parent::__construct($pocketAggregate, $caseReport);

		$this->getPockets()->addPocket('Request', new LockedPocket(
			(new EvidenceClue(
					static function()
					{
						return $_GET;
					})
				)->setLabel('$_GET'),
			(new EvidenceClue(
					static function()
					{
						return $_POST;
					})
				)->setLabel('$_POST'),
			(new EvidenceClue(
					static function()
					{
						return $_COOKIE;
					})
				)->setLabel('$_COOKIE')
			));

		$this->getPockets()->addPocket('Session', new LockedPocket(
			(new EvidenceClue(
					static function()
					{
						return $_SESSION ?? [];
					})
				)->setLabel('$_SESSION')
			));

		$this->getPockets()->addPocket('Server', new LockedPocket(
			(new EvidenceClue(
					static function()
					{
						return $_SERVER ?? [];
					})
				)->setLabel('$_SERVER')
			));

		$this->getPockets()->addPocket('Files', new ShallowPocket(
			(new EvidenceClue(static function()
			{
				return get_included_files();
			}))->setLabel('get_included_files()'),
		));
	}
}
