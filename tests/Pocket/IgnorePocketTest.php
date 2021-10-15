<?php

namespace Kluzo\Tests;

use Kluzo\Pocket\IgnorePocket;
use PHPUnit\Framework\TestCase;

use function iterator_to_array;

class IgnorePocketTest extends TestCase
{
	/**
	* @covers Kluzo\Pocket\IgnorePocket::__construct()
	* @covers Kluzo\Pocket\IgnorePocket::getIterator()
	*/
	function testConstructorWithArray()
	{
		$pocket = new IgnorePocket;
		$pocket->put(1,2,3,4);

		$things = iterator_to_array($pocket);
		$this->assertEquals($things, []);
	}
}
