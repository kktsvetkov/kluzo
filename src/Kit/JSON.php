<?php

namespace Kluzo\Kit;

use const JSON_ERROR_NONE;

use function json_decode;
use function json_last_error;

class JSON
{
	static function unJSON( $subject )
	{
		$raw = json_decode($subject , true);
		return (json_last_error() === JSON_ERROR_NONE)
			? $raw
			: $subject;
	}
}
