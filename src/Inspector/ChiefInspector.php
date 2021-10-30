<?php

namespace Kluzo\Inspector;

use Kluzo\Clue\ClueInterface as Clue;
use Kluzo\Clue\Evidence as EvidenceClue;
use Kluzo\Clue\Testimony as TestimonyClue;
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

		$this->getPockets()->addPocket('Request', new LockedPocket(
			(new EvidenceClue(
					static function()
					{
						return $_GET;
					})
				)->setLabel('$_GET')->formatAs('assoc'),
			(new EvidenceClue(
					static function()
					{
						return $_POST;
					})
				)->setLabel('$_POST')->formatAs('assoc'),
			(new EvidenceClue(
					static function()
					{
						return $_COOKIE;
					})
				)->setLabel('$_COOKIE')->formatAs('assoc')
			));

		$this->getPockets()->addPocket('Session', new LockedPocket(
			(new EvidenceClue(
					static function()
					{
						return $_SESSION ?? [];
					})
				)->setLabel('$_SESSION')->formatAs('assoc')
			));

		$this->getPockets()->addPocket('Server', new LockedPocket(
			(new EvidenceClue(
					static function()
					{
						return $_SERVER ?? [];
					})
				)->setLabel('$_SERVER')->formatAs('assoc')
			));

		$this->getPockets()->addPocket('Files', new LockedPocket(
			(new EvidenceClue(
					static function()
					{
						return get_included_files();
					})
				)->setLabel('get_included_files()')->formatAs('list'),
		));
	}


	function cleanPocket(string $pocketName) : self
	{
		$pocket = $this->getPockets()->getPocket($pocketName);

		if ($pocket instanceOf LockedPocket)
		{
			$pocket->clean();
			return $this;
		}

		if (null === $pocket)
		{
			return $this;
		}

		$count = $pocket->count();
		$pocket->clean();

		$pocket->put( (new TestimonyClue(
			"Pocked cleaned, clues removed: {$count}"
			))->formatAs('info') );

		return $this;
	}

	function unblockPocket(string $pocketName) : self
	{
		parent::unblockPocket($pocketName);

		$this->log($pocketName, 'Pocked unblocked')->formatAs('info');
		return $this;
	}

	function blockPocket(string $pocketName) : self
	{
		$this->log($pocketName, 'Pocked blocked')->formatAs('info');
		return parent::blockPocket($pocketName);
	}

	function miss(string $pocketName, ...$things) : Clue
	{
		return $this->log($pocketName, ...$things)->miss();
	}

	function html(string $pocketName, ...$things) : Clue
	{
		return $this->log($pocketName, ...$things)->html();
	}

	function text(string $pocketName, ...$things) : Clue
	{
		return $this->log($pocketName, ...$things)->text();
	}
}
