<?php

namespace Kluzo\Disguise\Format;

use Kluzo\Disguise\FormatInterface as DisguiseFormat;
use IteratorAggregate;

interface FormatAggregateInterface extends IteratorAggregate
{
	function getFormat(string $formatName) : DisguiseFormat;
	function setFormat(string $formatName, DisguiseFormat $format) : self;
}
