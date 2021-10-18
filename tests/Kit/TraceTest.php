<?php

namespace Kluzo\Tests;

use Kluzo\Kit\Trace as TraceKit;
use PHPUnit\Framework\TestCase;

use function strpos;

class TraceTest extends TestCase
{
	function dummy()
	{
		$trace = TraceKit::getTraceBack(); $file = __FILE__; $line = __LINE__;
		return [$trace, $file, $line];
	}

	function testGetTraceBack()
	{
		[$trace, $file, $line] = $this->dummy();
		$this->assertFalse(
			strpos($trace, "{$file}:{$line}")
			);
	}
}
