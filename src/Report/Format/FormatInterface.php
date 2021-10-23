<?php

namespace Kluzo\Report\Format;

interface FormatInterface
{
	function format($thing) : string;
}
