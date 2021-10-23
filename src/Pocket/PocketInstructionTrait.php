<?php

namespace Kluzo\Pocket;

use function array_filter;
use function array_merge;
use function is_string;

trait PocketInstructionTrait
{
	protected $instructions = array();

	function with(...$instructions) : self
	{
		$with = array_filter($instructions, static function($instruction)
		{
			return is_string($instruction);
		});

		$this->instructions = array_merge( $with, $this->instructions );

		return $this;
	}

	function without(...$instructions) : self
	{
		$without = array_filter($instructions, function($instruction)
		{
			return is_string($instruction);
		});

		$this->instructions = array_diff( $this->instructions, $without );

		return $this;
	}

	function is(string $instruction) : bool
	{
		return in_array($instruction, $this->instructions);
	}
}
