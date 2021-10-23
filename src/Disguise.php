<?php

namespace Kluzo;

use Kluzo\Inspector\AbstractInspector as Inspector;
use Kluzo\Inspector\ChiefInspector as DefaultInspector;

use function strtolower;

final class Disguise
{
	static private $inspector;

	static function setInspector(Inspector $inspector) : Inspector
	{
		if (self::$inspector)
		{
			self::$inspector->closeCase();
			unset(self::$inspector);
		}

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
		'enable' => 'resumeCase',
		'disable' => 'suspendCase',
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
