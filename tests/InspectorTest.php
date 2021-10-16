<?php

namespace Kluzo\Tests;

use Kluzo\Inspector;
use Kluzo\Pocket\ArrayPocket;
use Kluzo\Pocket\PocketFactory;
use PHPUnit\Framework\TestCase;

use function iterator_to_array;

class InspectorTest extends TestCase
{
	/**
	* @covers Kluzo\Inspector::__construct()
	* @covers Kluzo\Inspector::getIterator()
	* @covers Kluzo\Inspector::getPocket()
	*/
	function testConstructor()
	{
		$inspector = new Inspector($source = [
			'eleven' => $eleven = new ArrayPocket(11,11,11),
			'twelve' => new ArrayPocket(12,12,12,12)
		]);

		$pockets = iterator_to_array($inspector);
		$this->assertEquals($pockets, $source);

		$pocket = $inspector->getPocket('eleven');
		$this->assertEquals($pocket, $eleven);
	}

	/**
	* @covers Kluzo\Inspector::addPocket()
	* @covers Kluzo\Inspector::getPocket()
	* @covers Kluzo\Inspector::getIterator()
	*/
	function testAddPocket()
	{
		$inspector = new Inspector;

		$inspector->addPocket('eleven', $eleven = new ArrayPocket(11,11));
		$pockets = iterator_to_array($inspector);
		$this->assertEquals($pockets, ['eleven' => $eleven]);

		$pocket = $inspector->getPocket('eleven');
		$this->assertEquals($pocket, $eleven);
	}

	/**
	* @covers Kluzo\Inspector::dropPocket()
	* @covers Kluzo\Inspector::getPocket()
	* @covers Kluzo\Inspector::getIterator()
	*/
	function testDropPocket()
	{
		$inspector = new Inspector;

		$inspector->addPocket('eleven', $eleven = new ArrayPocket(11,11));
		$pockets = iterator_to_array($inspector);
		$this->assertEquals($pockets, ['eleven' => $eleven]);

		$inspector->dropPocket('eleven');
		$pockets = iterator_to_array($inspector);
		$this->assertEquals($pockets, []);
	}

	/**
	* @covers Kluzo\Inspector::cleanPocket()
	* @covers Kluzo\Inspector::getPocket()
	*/
	function testCleanPocket()
	{
		$inspector = new Inspector([
			'eleven' => new ArrayPocket(11,11)
			]);

		$pocket = $inspector->getPocket('eleven');
		$things = iterator_to_array($pocket);
		$this->assertEquals($things, [11,11]);

		$inspector->cleanPocket('eleven');
		$things = iterator_to_array($pocket);
		$this->assertEquals($things, []);
	}

	/**
	* @covers Kluzo\Inspector::setEmptyPocketFactory()
	* @covers Kluzo\Inspector::createEmptyPocket()
	*/
	function testEmptyPocketFactory()
	{
		$inspector = new Inspector;
		$inspector->setEmptyPocketFactory(
			PocketFactory::withArrayPocket()
			);
		$pocket = $inspector->createEmptyPocket();
		$this->assertInstanceOf(ArrayPocket::class, $pocket);
	}

	/**
	* @covers Kluzo\Inspector::log()
	* @covers Kluzo\Inspector::createEmptyPocket()
	* @covers Kluzo\Inspector::setEmptyPocketFactory()
	*/
	function testEmptyPocketLogging()
	{
		$inspector = new Inspector;
		$inspector->setEmptyPocketFactory(
			PocketFactory::withArrayPocket()
			);

		$inspector->log('eleven', 11, 11);
		$this->assertInstanceOf(
			ArrayPocket::class,
			$pocket = $inspector->getPocket('eleven')
			);
		$things = iterator_to_array($pocket);
		$this->assertEquals($things, [11,11]);
	}

	/**
	* @covers Kluzo\Inspector::enableInspector()
	* @covers Kluzo\Inspector::disableInspector()
	* @covers Kluzo\Inspector::isEnabled()
	*/
	function testEnableInspector()
	{
		$inspector = new Inspector;
		$inspector->disableInspector();
		$this->assertFalse($inspector->isEnabled());

		$inspector->enableInspector();
		$this->assertTrue($inspector->isEnabled());
	}

	/**
	* @covers Kluzo\Inspector::enableInspector()
	* @covers Kluzo\Inspector::disableInspector()
	* @covers Kluzo\Inspector::log()
	*/
	function testEnableInspectorLog()
	{
		$inspector = new Inspector([
			'eleven' => new ArrayPocket
			]);

		$inspector->log('eleven', 11, 11);
		$pocket = $inspector->getPocket('eleven');
		$things = iterator_to_array( $pocket );
		$this->assertEquals($things, [11,11]);

		$inspector->disableInspector();
		$inspector->log('eleven', 11, 11, 11);
		$things = iterator_to_array( $pocket );
		$this->assertEquals($things, [11,11]);

		$inspector->enableInspector();
		$inspector->log('eleven', 11, 11, 11);
		$things = iterator_to_array( $pocket );
		$this->assertEquals($things, [11,11,11,11,11]);
	}

	/**
	* @covers Kluzo\Inspector::enablePocket()
	* @covers Kluzo\Inspector::disablePocket()
	* @covers Kluzo\Inspector::log()
	*/
	function testEnablePocketLog()
	{
		$inspector = new Inspector([
			'eleven' => new ArrayPocket
			]);

		$inspector->log('eleven', 11, 11);
		$pocket = $inspector->getPocket('eleven');
		$things = iterator_to_array( $pocket );
		$this->assertEquals($things, [11,11]);

		$inspector->disablePocket('eleven');
		$inspector->log('eleven', 11, 11, 11);
		$things = iterator_to_array( $pocket );
		$this->assertEquals($things, [11,11]);

		$inspector->enablePocket('eleven');
		$inspector->log('eleven', 11, 11, 11);
		$things = iterator_to_array( $pocket );
		$this->assertEquals($things, [11,11,11,11,11]);
	}
}
