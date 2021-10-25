<?php

namespace Kluzo\Tests;

use Kluzo\Clue\ClueInterface as Clue;
use Kluzo\Clue\Testimony as TestimonyClue;
use Kluzo\Pocket\Aggregate\DefaultAggregate as PocketAggregate;
use Kluzo\Pocket\ArrayPocket;
use PHPUnit\Framework\TestCase;

use function iterator_to_array;

class PocketAggregateTest extends TestCase
{
	/**
	* @covers Kluzo\Pocket\PocketAggregate::__construct()
	* @covers Kluzo\Pocket\PocketAggregate::getIterator()
	* @covers Kluzo\Pocket\PocketAggregate::getPocket()
	*/
	function testConstructor()
	{
		$aggregate = new PocketAggregate($source = [
			'eleven' => $eleven = new ArrayPocket(
				new TestimonyClue(11,11,11)),
			'twelve' => new ArrayPocket(
				new TestimonyClue(12,12,12,12)
				)
			]);

		$pockets = iterator_to_array($aggregate);
		$this->assertEquals($pockets, $source);

		$pocket = $aggregate->getPocket('eleven');
		$this->assertEquals($pocket, $eleven);
	}

	/**
	* @covers Kluzo\Pocket\PocketAggregate::addPocket()
	* @covers Kluzo\Pocket\PocketAggregate::getPocket()
	* @covers Kluzo\Pocket\PocketAggregate::getIterator()
	*/
	function testAddPocket()
	{
		$aggregate = new PocketAggregate;

		$aggregate->addPocket('eleven', $eleven = new ArrayPocket(new TestimonyClue(11,11)));
		$pockets = iterator_to_array($aggregate);
		$this->assertEquals($pockets, ['eleven' => $eleven]);

		$pocket = $aggregate->getPocket('eleven');
		$this->assertEquals($pocket, $eleven);
	}

	/**
	* @covers Kluzo\Pocket\PocketAggregate::dropPocket()
	* @covers Kluzo\Pocket\PocketAggregate::getPocket()
	* @covers Kluzo\Pocket\PocketAggregate::getIterator()
	*/
	function testDropPocket()
	{
		$aggregate = new PocketAggregate;

		$aggregate->addPocket('eleven', $eleven = new ArrayPocket(new TestimonyClue(11,11)));
		$pockets = iterator_to_array($aggregate);
		$this->assertEquals($pockets, ['eleven' => $eleven]);

		$aggregate->dropPocket('eleven');
		$pockets = iterator_to_array($aggregate);
		$this->assertEquals($pockets, []);
	}

	/**
	* @covers Kluzo\Pocket\PocketAggregate::cleanPocket()
	* @covers Kluzo\Pocket\PocketAggregate::getPocket()
	*/
	function testCleanPocket()
	{
		$aggregate = new PocketAggregate([
			'eleven' => new ArrayPocket(
				$clue11 = new TestimonyClue(11,11)
				)
			]);

		$pocket = $aggregate->getPocket('eleven');
		$things = iterator_to_array($pocket);
		$this->assertEquals($things, [$clue11]);

		$aggregate->cleanPocket('eleven');
		$things = iterator_to_array($pocket);
		$this->assertEquals($things, []);
	}
}
