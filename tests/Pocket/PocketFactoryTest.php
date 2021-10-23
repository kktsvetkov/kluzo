<?php

namespace Kluzo\Tests;

use Kluzo\Clue\ClueInterface as Clue;
use Kluzo\Clue\Testimony as TestimonyClue;
use Kluzo\Pocket\PocketFactory;
use Kluzo\Pocket\ArrayPocket;
use PHPUnit\Framework\TestCase;

use function iterator_to_array;

class PocketFactoryTest extends TestCase
{
	/**
	* @covers Kluzo\Pocket\PocketFactory::__construct()
	* @covers Kluzo\Pocket\PocketFactory::createPocket()
	*/
	function testConstructor()
	{
		$factory = new PocketFactory(function()
		{
			return new ArrayPocket(new TestimonyClue(11,22,33,44));
		});

		$pocket = $factory->createPocket();
		$this->assertInstanceOf(ArrayPocket::class, $pocket);

		$things = iterator_to_array($pocket);
		$this->assertEquals($things, [new TestimonyClue(11,22,33,44)]);
	}

	/**
	* @covers Kluzo\Pocket\PocketFactory::__construct()
	* @covers Kluzo\Pocket\PocketFactory::createPocket()
	* @covers Kluzo\Pocket\PocketFactory::withArrayPocket()
	*/
	function testWithArrayPocket()
	{
		$factory = PocketFactory::withArrayPocket();
		$this->assertInstanceOf(PocketFactory::class, $factory);

		$pocket = $factory->createPocket();
		$this->assertInstanceOf(ArrayPocket::class, $pocket);
	}
}
