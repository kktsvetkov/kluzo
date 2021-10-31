<?php

namespace Kluzo\Kit;

use DOMDocument;

class XML
{
	static function formatXML(string $xml) : string
	{
		if (!class_exists(DOMDocument::class))
		{
			return $xml;
		}

		$dom = new DOMDocument;
		$dom->formatOutput = true;
		$dom->preserveWhiteSpace = false;
		$dom->strictErrorChecking = false;

		return $dom->loadXML($xml, 96)
			? $dom->saveXML()
			: $xml;
	}
}
