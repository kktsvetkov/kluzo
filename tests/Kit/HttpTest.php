<?php

namespace Kluzo\Tests;

use Kluzo\Kit\HTTP as HttpKit;
use PHPUnit\Framework\TestCase;

class HttpTest extends TestCase
{
	function testIsOutputHTML()
	{
		$this->assertTrue(
			HttpKit::isOutputHTML([
				'Expires: Thu, 19 Nov 1981 08:52:00 GMT',
				'Cache-Control: no-store, no-cache, must-revalidate',
				'Pragma: no-cache',
				'X-Admin: 1',
				'Set-Cookie: marker=3ec3650adcb07a6e7b55700608e171707b1f12e5; expires=Wed, 20-Oct-2021 04:59:22 GMT; Max-Age=604800; path=/; secure; HttpOnly',
				'Content-type: text/html; charset=UTF-8',
			])
		);

		$this->assertFalse(
			HttpKit::isOutputHTML([
				'Content-type: application/json',
			])
		);

		$this->assertFalse(
			HttpKit::isOutputHTML([
				'Content-type: text/plain; charset=UTF-8',
			])
		);
	}
}
