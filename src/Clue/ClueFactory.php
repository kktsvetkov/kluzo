<?php

namespace Kluzo\Clue;

use Kluzo\Clue\ClueInterface as Clue;
use Kluzo\Clue\ClueFactoryInterface;
use Kluzo\Clue\Evidence;
use Kluzo\Clue\Testimony;

class ClueFactory implements ClueFactoryInterface
{
	protected $callback;

	function __construct(callable $clueCallback)
	{
		$this->callback = $clueCallback;
	}

	function createClue(...$things) : Clue
	{
		$clueCallback = $this->callback;
		return $clueCallback(...$things);
	}

	static function withClueEvidence() : self
	{
		return new self(function(...$things)
		{
			return new Evidence(...$things);
		});
	}

	static function withClueTestimony() : self
	{
		return new self(function(...$things)
		{
			return new Testimony(...$things);
		});
	}
}
