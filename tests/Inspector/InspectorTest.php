<?php

namespace Kluzo\Tests;

use Kluzo\Inspector\Inspector;

use Kluzo\Pocket\ArrayPocket;
use Kluzo\Pocket\PocketAggregate;
use Kluzo\Pocket\PocketFactory;

use PHPUnit\Framework\TestCase;

use function iterator_to_array;

class InspectorTest extends TestCase
{
	/**
	* @covers Kluzo\Inspector\Inspector::__construct()
	* @covers Kluzo\Inspector\Inspector::getPockets()
	*/
	function testConstructor()
	{
		$aggregate = new PocketAggregate([
			'eleven' => new ArrayPocket(11,11,11),
			'twelve' => new ArrayPocket(12,12,12,12)
		]);

		$inspector = new Inspector($aggregate);
		$this->assertEquals($aggregate, $inspector->getPockets());
	}

	/**
	* @covers Kluzo\Inspector\Inspector::__construct()
	* @covers Kluzo\Inspector\Inspector::getPockets()
	*/
	function testEmptyConstructor()
	{
		$inspector = new Inspector;
		$this->assertEquals(new PocketAggregate, $empty = $inspector->getPockets());
		$this->assertInstanceOf(PocketAggregate::class, $empty);
	}

	/**
	* @covers Kluzo\Inspector\Inspector::log()
	* @covers Kluzo\Inspector\Inspector::getPockets()
	*/
	function testEmptyPocketLogging()
	{
		$inspector = new Inspector;
		$inspector->getPockets()->setEmptyPocketFactory(
			PocketFactory::withArrayPocket()
			);

		$inspector->log('eleven', 11, 11);
		$this->assertInstanceOf(
			ArrayPocket::class,
			$pocket = $inspector->getPockets()->getPocket('eleven')
			);

		$things = iterator_to_array($pocket);
		$this->assertEquals($things, [11,11]);
	}

	/**
	* @covers Kluzo\Inspector\Inspector::enableInspector()
	* @covers Kluzo\Inspector\Inspector::disableInspector()
	* @covers Kluzo\Inspector\Inspector::isEnabled()
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
	* @covers Kluzo\Inspector\Inspector::enableInspector()
	* @covers Kluzo\Inspector\Inspector::disableInspector()
	* @covers Kluzo\Inspector\Inspector::log()
	*/
	function testEnableInspectorLog()
	{
		$inspector = new Inspector(
			new PocketAggregate([
				'eleven' => new ArrayPocket
			]));

		$inspector->log('eleven', 11, 11);
		$pocket = $inspector->getPockets()->getPocket('eleven');
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
	* @covers Kluzo\Inspector\Inspector::enablePocket()
	* @covers Kluzo\Inspector\Inspector::disablePocket()
	* @covers Kluzo\Inspector\Inspector::log()
	*/
	function testEnablePocketLog()
	{
		$inspector = new Inspector(
			new PocketAggregate([
				'eleven' => new ArrayPocket
			]));

		$inspector->log('eleven', 11, 11);
		$pocket = $inspector->getPockets()->getPocket('eleven');
		$things = iterator_to_array( $pocket );
		$this->assertEquals($things, [11,11]);

		$inspector->blockPocket('eleven');
		$inspector->log('eleven', 11, 11, 11);
		$things = iterator_to_array( $pocket );
		$this->assertEquals($things, [11,11]);

		$inspector->unblockPocket('eleven');
		$inspector->log('eleven', 11, 11, 11);
		$things = iterator_to_array( $pocket );
		$this->assertEquals($things, [11,11,11,11,11]);
	}
}
