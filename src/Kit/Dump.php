<?php

namespace Kluzo\Kit;

use function print_r;
use function ob_start;
use function ob_get_clean;
use function var_dump;

class Dump
{
	const PRINT_R = '\\Kluzo\\Kit\\Dump::print_r';

	const VAR_DUMP = '\\Kluzo\\Kit\\Dump::var_dump';

	static protected $dumpCallback = self::PRINT_R;

	function dumpWith(callable $dumpCallback) : callable
	{
		$old = self::$dumpCallback;
		self::$dumpCallback = $dumpCallback;
		return $old;
	}

	static function dump($thing) : string
	{
		return (self::$dumpCallback)($thing);
	}

	static function print_r($thing) : string
	{
		return print_r($thing, true) . "\n";
	}

	static function var_dump($thing) : string
	{
		ob_start();
		var_dump($thing);
		return ob_get_clean();
	}
}
