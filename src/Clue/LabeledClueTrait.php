<?php

namespace Kluzo\Clue;

use Kluzo\Clue\MetaTrait;

trait LabeledClueTrait
{
	use MetaTrait;

	function setLabel(string $label) : self
	{
		$this->meta[ 'label' ] = $label;
		return $this;
	}

	function getLabel() : string
	{
		return $this->meta[ 'label' ] ?? '';
	}

	function label(string $label = null)
	{
		return (null !== $label)
			? $this->setLabel($label)
			: $this->getLabel();
	}
}
