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
		'ison' => 'isCaseActive',
		'isoff' => 'isCaseSuspended',
		'on' => 'resumeCase',
		'off' => 'suspendCase',
		'enable' => 'resumeCase',
		'disable' => 'suspendCase',
		'allow' => 'unblockPocket',
		'ban' => 'blockPocket',
		'clear' => 'cleanPocket',
		'clean' => 'cleanPocket',
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
