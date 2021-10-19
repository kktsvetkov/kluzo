<?php

namespace Kluzo\Tests;

use Kluzo\Clue\Evidence;
use PHPUnit\Framework\TestCase;

use function iterator_to_array;

class EvidenceTest extends TestCase
{
	/**
	* @covers Kluzo\Clue\Evidence::__construct()
	* @covers Kluzo\Clue\Evidence::getIterator()
	*/
	function testConstructorWithArray()
	{
		$Clue = new Evidence(function()
		{
			return $_SERVER;
		});
		
		$things = iterator_to_array($Clue);
		$this->assertEquals($things, $_SERVER);
	}

	/**
	* @covers Kluzo\Clue\Evidence::__construct()
	* @covers Kluzo\Clue\Evidence::getIterator()
	*/
	function testConstructorWithFunction()
	{
		$Clue = new Evidence('get_included_files');
		$things = iterator_to_array($Clue);
		$this->assertEquals($things, get_included_files());
	}
}
