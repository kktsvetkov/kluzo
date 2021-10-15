<?php

namespace Kluzo\Tests;

use Kluzo\Pocket\PocketFactory;
use Kluzo\Pocket\ArrayPocket;
use Kluzo\Pocket\IgnorePocket;

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
			return new ArrayPocket(11,22,33,44);
		});

		$pocket = $factory->createPocket();
		$this->assertInstanceOf(ArrayPocket::class, $pocket);

		$things = iterator_to_array($pocket);
		$this->assertEquals($things, [11,22,33,44]);
	}

	/**
	* @covers Kluzo\Pocket\PocketFactory::__construct()
	* @covers Kluzo\Pocket\PocketFactory::createPocket()
	* @covers Kluzo\Pocket\PocketFactory::withIgnorePocket()
	*/
	function testWithIgnorePocket()
	{
		$factory = PocketFactory::withIgnorePocket();
		$this->assertInstanceOf(PocketFactory::class, $factory);

		$pocket = $factory->createPocket();
		$this->assertInstanceOf(IgnorePocket::class, $pocket);
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
