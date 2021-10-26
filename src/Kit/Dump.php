<?php

namespace Kluzo\Kit;

use function print_r;

class Dump
{
	static protected $dumpCallback = '\\Kluzo\\Kit\\Dump::print_r';

	function dumpWith(callable $dumpCallback) : callable
	{
		$old = self::$dumpCallback;
		self::$dumpCallback = $dumpCallback;
		return $old;
	}

	static function print_r($thing) : string
	{
		return print_r($thing, true);
	}

	static function dump($thing) : string
	{
		return (self::$dumpCallback)($thing);
	}

}
