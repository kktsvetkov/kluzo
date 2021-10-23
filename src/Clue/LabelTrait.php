<?php

namespace Kluzo\Clue;

trait LabelTrait
{
	protected $label = '';

	function setLabel(string $label) : self
	{
		$this->label = $label;
		return $this;
	}

	function getLabel() : string
	{
		return $this->label;
	}
}
