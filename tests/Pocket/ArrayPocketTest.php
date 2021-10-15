<?php

namespace Kluzo\Tests;

use Kluzo\Pocket\ArrayPocket;
use PHPUnit\Framework\TestCase;

use function iterator_to_array;

class ArrayPocketTest extends TestCase
{
	/**
	* @covers Kluzo\Pocket\ArrayPocket::__construct()
	* @covers Kluzo\Pocket\ArrayPocket::put()
	* @covers Kluzo\Pocket\ArrayPocket::getIterator()
	*/
	function testConstructor()
	{
		$pocket = new ArrayPocket(1,2,3,4);
		$things = iterator_to_array($pocket);
		$this->assertEquals($things, [1,2,3,4]);
	}

	/**
	* @covers Kluzo\Pocket\ArrayPocket::put()
	* @covers Kluzo\Pocket\ArrayPocket::getIterator()
	*/
	function testPut()
	{
		$pocket = new ArrayPocket;
		$pocket->put(11);
		$this->assertEquals(iterator_to_array($pocket), [11]);

		$pocket->put(22);
		$this->assertEquals(iterator_to_array($pocket), [11, 22]);

		$pocket->put(33, 44);
		$this->assertEquals(iterator_to_array($pocket), [11, 22, 33, 44]);
	}

	/**
	* @covers Kluzo\Pocket\ArrayPocket::put()
	* @covers Kluzo\Pocket\ArrayPocket::getIterator()
	*/
	function testPutMixed()
	{
		$pocket = new ArrayPocket;
		$pocket->put(11);
		$this->assertEquals(iterator_to_array($pocket), [11]);

		$pocket->put([], $object = (object) []);
		$this->assertEquals(iterator_to_array($pocket), [11, [], $object]);
	}

	/**
	* @covers Kluzo\Pocket\ArrayPocket::clean()
	* @covers Kluzo\Pocket\ArrayPocket::put()
	* @covers Kluzo\Pocket\ArrayPocket::getIterator()
	*/
	function testClean()
	{
		$pocket = new ArrayPocket;
		$pocket->put(11);
		$this->assertEquals(iterator_to_array($pocket), [11]);

		$pocket->clean();
		$this->assertEquals(iterator_to_array($pocket), []);
	}
}
