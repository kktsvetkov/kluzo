<?php

namespace Kluzo\Tests;

use Kluzo\Clue\Testimony;
use PHPUnit\Framework\TestCase;

use function iterator_to_array;

class TestimonyTest extends TestCase
{
	/**
	* @covers Kluzo\Clue\Testimony::__construct()
	* @covers Kluzo\Clue\Testimony::getIterator()
	*/
	function testConstructor()
	{
		$clue = new Testimony(1,2,3,4);
		$things = iterator_to_array($clue);
		$this->assertEquals($things, [1,2,3,4]);
	}

	/**
	* @covers Kluzo\Clue\Testimony::put()
	* @covers Kluzo\Clue\Testimony::getIterator()
	*/
	function testPutMixed()
	{
		$clue = new Testimony(11, [22], $object = (object) []);
		$this->assertEquals(iterator_to_array($clue), [11, [22], $object]);
	}
}
