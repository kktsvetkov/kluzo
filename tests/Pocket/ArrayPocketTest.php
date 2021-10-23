<?php

namespace Kluzo\Tests;

use Kluzo\Clue\ClueInterface as Clue;
use Kluzo\Clue\Testimony as TestimonyClue;
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
		$pocket = new ArrayPocket(
			$clue = new TestimonyClue(1,2,3,4)
			);
		$clues = iterator_to_array($pocket);
		$this->assertEquals($clues, [$clue]);
	}

	/**
	* @covers Kluzo\Pocket\ArrayPocket::put()
	* @covers Kluzo\Pocket\ArrayPocket::getIterator()
	*/
	function testPut()
	{
		$pocket = new ArrayPocket;
		$pocket->put($clue = new TestimonyClue(11));
		$this->assertEquals(iterator_to_array($pocket), [$clue]);

		$pocket->put($clue2 = new TestimonyClue(22));
		$this->assertEquals(iterator_to_array($pocket), [$clue, $clue2]);

		$pocket->put($clue3 = new TestimonyClue(33, 44));
		$this->assertEquals(iterator_to_array($pocket), [$clue, $clue2, $clue3]);
	}

	/**
	* @covers Kluzo\Pocket\ArrayPocket::put()
	* @covers Kluzo\Pocket\ArrayPocket::getIterator()
	*/
	function testPutMixed()
	{
		$pocket = new ArrayPocket;
		$pocket->put($clue = new TestimonyClue(11));
		$this->assertEquals(iterator_to_array($pocket), [$clue]);

		$pocket->put($clue2 = new TestimonyClue([], $object = (object) []));
		$this->assertEquals(iterator_to_array($pocket), [$clue, $clue2]);
	}

	/**
	* @covers Kluzo\Pocket\ArrayPocket::clean()
	* @covers Kluzo\Pocket\ArrayPocket::put()
	* @covers Kluzo\Pocket\ArrayPocket::getIterator()
	*/
	function testClean()
	{
		$pocket = new ArrayPocket;
		$pocket->put($clue = new TestimonyClue(11));
		$this->assertEquals(iterator_to_array($pocket), [$clue]);

		$pocket->clean();
		$this->assertEquals(iterator_to_array($pocket), []);
	}
}
