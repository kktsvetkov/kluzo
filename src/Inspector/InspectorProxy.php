<?php

namespace Kluzo\Inspector;

use Kluzo\Inspector\InspectorInterface as Inspector;
use Kluzo\Inspector\Inspector as DefaultInspector;

use function strtolower;

final class InspectorProxy
{
	static private $inspector;

	static function setInspector(Inspector $inspector) : Inspector
	{
		return self::$inspector = $inspector;
	}

	static function getInspector() : Inspector
	{
		return self::$inspector ?? (
			self::$inspector = new DefaultInspector
			);
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
