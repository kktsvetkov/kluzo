<?php

namespace Kluzo\Tests;

use Kluzo\Pocket\PocketAggregate;
use Kluzo\Pocket\PocketFactory;
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
			'eleven' => $eleven = new ArrayPocket(11,11,11),
			'twelve' => new ArrayPocket(12,12,12,12)
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

		$aggregate->addPocket('eleven', $eleven = new ArrayPocket(11,11));
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

		$aggregate->addPocket('eleven', $eleven = new ArrayPocket(11,11));
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
			'eleven' => new ArrayPocket(11,11)
			]);

		$pocket = $aggregate->getPocket('eleven');
		$things = iterator_to_array($pocket);
		$this->assertEquals($things, [11,11]);

		$aggregate->cleanPocket('eleven');
		$things = iterator_to_array($pocket);
		$this->assertEquals($things, []);
	}

	/**
	* @covers Kluzo\Pocket\PocketAggregate::setEmptyPocketFactory()
	* @covers Kluzo\Pocket\PocketAggregate::createEmptyPocket()
	*/
	function testEmptyPocketFactory()
	{
		$aggregate = new PocketAggregate;
		$aggregate->setEmptyPocketFactory(
			PocketFactory::withArrayPocket()
			);
		$pocket = $aggregate->createEmptyPocket();
		$this->assertInstanceOf(ArrayPocket::class, $pocket);
	}
}
