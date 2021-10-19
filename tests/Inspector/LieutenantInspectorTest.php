<?php

namespace Kluzo\Tests;

use Kluzo\Inspector\LieutenantInspector;

use Kluzo\Pocket\ArrayPocket;
use Kluzo\Pocket\PocketAggregate;
use Kluzo\Pocket\PocketFactory;

use PHPUnit\Framework\TestCase;

use function iterator_to_array;

class LieutenantInspectorTest extends TestCase
{
	/**
	* @covers Kluzo\Inspector\LieutenantInspector::__construct()
	* @covers Kluzo\Inspector\LieutenantInspector::getPockets()
	*/
	function testConstructor()
	{
		$aggregate = new PocketAggregate([
			'eleven' => new ArrayPocket(11,11,11),
			'twelve' => new ArrayPocket(12,12,12,12)
		]);

		$inspector = new LieutenantInspector($aggregate);
		$this->assertEquals($aggregate, $inspector->getPockets());
	}

	/**
	* @covers Kluzo\Inspector\LieutenantInspector::__construct()
	* @covers Kluzo\Inspector\LieutenantInspector::getPockets()
	*/
	function testEmptyConstructor()
	{
		$inspector = new LieutenantInspector;
		$this->assertEquals(new PocketAggregate, $empty = $inspector->getPockets());
		$this->assertInstanceOf(PocketAggregate::class, $empty);
	}

	/**
	* @covers Kluzo\Inspector\LieutenantInspector::log()
	* @covers Kluzo\Inspector\LieutenantInspector::getPockets()
	*/
	function testEmptyPocketLogging()
	{
		$inspector = new LieutenantInspector;
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
	* @covers Kluzo\Inspector\LieutenantInspector::enableInspector()
	* @covers Kluzo\Inspector\LieutenantInspector::disableInspector()
	* @covers Kluzo\Inspector\LieutenantInspector::isEnabled()
	*/
	function testEnableInspector()
	{
		$inspector = new LieutenantInspector;
		$inspector->disableInspector();
		$this->assertFalse($inspector->isEnabled());

		$inspector->enableInspector();
		$this->assertTrue($inspector->isEnabled());
	}

	/**
	* @covers Kluzo\Inspector\LieutenantInspector::enableInspector()
	* @covers Kluzo\Inspector\LieutenantInspector::disableInspector()
	* @covers Kluzo\Inspector\LieutenantInspector::log()
	*/
	function testEnableInspectorLog()
	{
		$inspector = new LieutenantInspector(
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
	* @covers Kluzo\Inspector\LieutenantInspector::enablePocket()
	* @covers Kluzo\Inspector\LieutenantInspector::disablePocket()
	* @covers Kluzo\Inspector\LieutenantInspector::log()
	*/
	function testEnablePocketLog()
	{
		$inspector = new LieutenantInspector(
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
