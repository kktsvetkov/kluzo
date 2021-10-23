<?php

namespace Kluzo\Tests;

use Kluzo\Clue\Testimony as TestimonyClue;
use Kluzo\Inspector\DetectiveInspector as Inspector;
use Kluzo\Pocket\ArrayPocket;
use Kluzo\Pocket\PocketAggregate;
use Kluzo\Pocket\PocketFactory;
use Kluzo\Report\NonVocal as NonVocalReport;
use PHPUnit\Framework\TestCase;

use function iterator_to_array;

class InspectorTest extends TestCase
{
	/**
	* @covers Kluzo\Inspector\DetectiveInspector::__construct()
	* @covers Kluzo\Inspector\DetectiveInspector::getPockets()
	*/
	function testConstructor()
	{
		$aggregate = new PocketAggregate([
			'eleven' => new ArrayPocket(11,11,11),
			'twelve' => new ArrayPocket(12,12,12,12)
		]);

		$inspector = new Inspector($aggregate, new NonVocalReport);
		$this->assertEquals($aggregate, $inspector->getPockets());
	}

	/**
	* @covers Kluzo\Inspector\DetectiveInspector::__construct()
	* @covers Kluzo\Inspector\DetectiveInspector::getPockets()
	*/
	function testEmptyConstructor()
	{
		$inspector = new Inspector(null, new NonVocalReport);
		$this->assertEquals(new PocketAggregate, $empty = $inspector->getPockets());
		$this->assertInstanceOf(PocketAggregate::class, $empty);
	}

	/**
	* @covers Kluzo\Inspector\DetectiveInspector::log()
	* @covers Kluzo\Inspector\DetectiveInspector::getPockets()
	*/
	function testEmptyPocketLogging()
	{
		$inspector = new Inspector(null, new NonVocalReport);

		$inspector->log('eleven', 11, 11);
		$this->assertInstanceOf(
			ArrayPocket::class,
			$pocket = $inspector->getPockets()->getPocket('eleven')
			);

		$clues = iterator_to_array($pocket);
		$this->assertEquals($clues, [new TestimonyClue(11,11)]);
	}

	/**
	* @covers Kluzo\Inspector\DetectiveInspector::resumeCase()
	* @covers Kluzo\Inspector\DetectiveInspector::suspendCase()
	* @covers Kluzo\Inspector\DetectiveInspector::isCaseSuspended()
	*/
	function testEnableInspector()
	{
		$inspector = new Inspector(null, new NonVocalReport);
		$inspector->suspendCase();
		$this->assertTrue($inspector->isCaseSuspended());

		$inspector->resumeCase();
		$this->assertFalse($inspector->isCaseSuspended());
	}

	/**
	* @covers Kluzo\Inspector\DetectiveInspector::resumeCase()
	* @covers Kluzo\Inspector\DetectiveInspector::suspendCase()
	* @covers Kluzo\Inspector\DetectiveInspector::log()
	*/
	function testEnableInspectorLog()
	{
		$inspector = new Inspector(
			new PocketAggregate([
				'eleven' => new ArrayPocket
			]), new NonVocalReport);

		$inspector->log('eleven', 11, 11);
		$pocket = $inspector->getPockets()->getPocket('eleven');
		$things = iterator_to_array( $pocket );
		$this->assertEquals($things, [new TestimonyClue(11,11)]);

		$inspector->suspendCase();
		$inspector->log('eleven', 11, 11, 11);
		$things = iterator_to_array( $pocket );
		$this->assertEquals($things, [new TestimonyClue(11,11)]);

		$inspector->resumeCase();
		$inspector->log('eleven', 11, 11, 11);
		$things = iterator_to_array( $pocket );
		$this->assertEquals($things, [new TestimonyClue(11,11), new TestimonyClue(11,11,11)]);
	}

	/**
	* @covers Kluzo\Inspector\DetectiveInspector::enablePocket()
	* @covers Kluzo\Inspector\DetectiveInspector::disablePocket()
	* @covers Kluzo\Inspector\DetectiveInspector::log()
	*/
	function testEnablePocketLog()
	{
		$inspector = new Inspector(
			new PocketAggregate([
				'eleven' => new ArrayPocket
			]), new NonVocalReport);

		$inspector->log('eleven', 11, 11);
		$pocket = $inspector->getPockets()->getPocket('eleven');
		$things = iterator_to_array( $pocket );
		$this->assertEquals($things, [new TestimonyClue(11,11)]);

		$inspector->blockPocket('eleven');
		$inspector->log('eleven', 11, 11, 11);
		$things = iterator_to_array( $pocket );
		$this->assertEquals($things, [new TestimonyClue(11,11)]);

		$inspector->unblockPocket('eleven');
		$inspector->log('eleven', 11, 11, 11);
		$things = iterator_to_array( $pocket );
		$this->assertEquals($things, [new TestimonyClue(11,11), new TestimonyClue(11,11,11)]);
	}
}
