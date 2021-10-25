<?php

namespace Kluzo\Report\Format;

use Kluzo\Clue\ClueInterface as Clue;
use Kluzo\Report\Format\FormatInterface as ReportFormat;
use Kluzo\Report\Format\DefaultFormat;

final class Register
{
	static protected $currentFormat;

	static function getFormat() : ReportFormat
	{
		return self::$currentFormat ?? (
			self::$currentFormat = new DefaultFormat
		);
	}

	static function setFormat(ReportFormat $format) : ?ReportFormat
	{
		$old = self::$currentFormat;
		self::$currentFormat = $format;
		return $old;
	}
}
