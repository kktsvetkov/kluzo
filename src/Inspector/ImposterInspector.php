<?php

namespace Kluzo\Inspector;

use Kluzo\Clue\Ignore as IgnoreClue;
use Kluzo\Inspector\AbstractInspector as Inspector;

class ImposterInspector extends Inspector
{
	function suspendCase() : self
	{
		return $this;
	}

	function resumeCase() : self
	{
		return $this;
	}

	function isCaseSuspended() : bool
	{
		return true;
	}

	function unblockPocket(string $pocketName) : self
	{
		return $this;
	}

	function blockPocket(string $pocketName) : self
	{
		return $this;
	}

	function cleanPocket(string $pocketName) : self
	{
		return $this;
	}

	function closeCase() : self
	{
		return $this;
	}

	function __destruct()
	{
		// do nothing, no report issued 
	}

	function log(string $pocketName, ...$things) : Clue
	{
		return new IgnoreClue;
	}
}
