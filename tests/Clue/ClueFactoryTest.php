<?php

namespace Kluzo\Tests;

use Kluzo\Clue\ClueFactory;
use Kluzo\Clue\Testimony;

use PHPUnit\Framework\TestCase;

use function iterator_to_array;

class ClueFactoryTest extends TestCase
{
	/**
	* @covers Kluzo\Clue\ClueFactory::__construct()
	* @covers Kluzo\Clue\ClueFactory::createClue()
	*/
	function testConstructor()
	{
		$factory = new ClueFactory(function(...$things)
		{
			return new Testimony(...$things);
		});

		$clue = $factory->createClue(11,22,33,44);
		$this->assertInstanceOf(Testimony::class, $clue);

		$things = iterator_to_array($clue);
		$this->assertEquals($things, [11,22,33,44]);
	}

	/**
	* @covers Kluzo\Clue\ClueFactory::__construct()
	* @covers Kluzo\Clue\ClueFactory::createClue()
	* @covers Kluzo\Clue\ClueFactory::withClueTestimony()
	*/
	function testWithArrayClue()
	{
		$factory = ClueFactory::withClueTestimony();
		$this->assertInstanceOf(ClueFactory::class, $factory);

		$clue = $factory->createClue();
		$this->assertInstanceOf(Testimony::class, $clue);
	}
}
