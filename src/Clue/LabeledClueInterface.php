<?php

namespace Kluzo\Clue;

interface LabeledClueInterface
{
	function setLabel(string $label) : self;

	function getLabel() : string;
}
