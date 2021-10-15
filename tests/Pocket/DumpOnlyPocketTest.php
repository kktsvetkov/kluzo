<?php

namespace Kluzo\Tests;

use Kluzo\Pocket\DumpOnlyPocket;
use PHPUnit\Framework\TestCase;

use function iterator_to_array;

class DumpOnlyPocketTest extends TestCase
{
	/**
	* @covers Kluzo\Pocket\DumpOnlyPocket::__construct()
	* @covers Kluzo\Pocket\DumpOnlyPocket::getIterator()
	*/
	function testConstructorWithArray()
	{
		$pocket = new DumpOnlyPocket(function()
		{
			return $_SERVER;
		});
		$things = iterator_to_array($pocket);
		$this->assertEquals($things, $_SERVER);
	}

	/**
	* @covers Kluzo\Pocket\DumpOnlyPocket::__construct()
	* @covers Kluzo\Pocket\DumpOnlyPocket::getIterator()
	*/
	function testConstructorWithFunction()
	{
		$pocket = new DumpOnlyPocket('get_included_files');
		$things = iterator_to_array($pocket);
		$this->assertEquals($things, get_included_files());
	}
}
