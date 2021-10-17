<?php

namespace Kluzo;

use Kluzo\Inspector;

use function strtolower;

final class ChiefInspector
{
	static private $inspector;

	static function setInspector(Inspector $inspector) : Inspector
	{
		return self::$inspector = $inspector;
	}

	static function getInspector() : Inspector
	{
		return self::$inspector ?? (self::$inspector = new Inspector);
	}

	private const METHOD_ALIAS = array(
		'ison' => 'isEnabled',
		'enable' => 'enableInspector',
		'disable' => 'disableInspector',
		'on' => 'unblockPocket',
		'off' => 'blockPocket',
		'clear' => 'cleanPocket',
	);

	static function __callStatic(string $method, array $args)
	{
		if ($alias = self::METHOD_ALIAS[ strtolower($method) ] ?? null)
		{
			$method = $alias;
		}

		return self::getInspector()->$method(...$args);
	}
}
