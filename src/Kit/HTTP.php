<?php

namespace Kluzo\Kit;

use function headers_list;
use function preg_match;

class HTTP
{
	/**
	* If the content-type of the current page is not HTML,
	* then perhaps it is not safe to introduce the debug dump
	*
	* @param array $headers
	* @return boolean
	*/
	static function isOutputHTML(array $headers = null) : bool
	{
		$headers = $headers ?: headers_list();
		if (!$headers)
		{
			return true;
		}

		foreach ($headers as $header)
		{
			if (preg_match('~^content\-type\:\s*text/html~Uis', $header))
			{
				return true;
			}
		}

		return false;
	}
}
