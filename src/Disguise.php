<?php

namespace Kluzo;

use Kluzo\Inspector\AbstractInspector as Inspector;
use Kluzo\Inspector\ChiefInspector as DefaultInspector;
use Kluzo\Inspector\ImposterInspector;
use Kluzo\Tricks;

use function strtolower;

final class Disguise
{
	static private $inspector;

	static function setInspector(Inspector $inspector) : Inspector
	{
		if (self::$inspector)
		{
			self::$inspector->suspendCase();
		}

		return self::$inspector = $inspector;
	}

	static function getInspector() : Inspector
	{
		return self::$inspector ?? (
			self::$inspector = new DefaultInspector
			);
	}

	static private $tricks;

	static function getTricks() : Tricks
	{
		return self::$tricks ?? (
			self::$tricks = new Tricks(
				self::getInspector()
			));
	}

	static function __callStatic(string $method, array $args)
	{
		return (self::getTricks())->$method(...$args);
	}

	static function mute() : Inspector
	{
		return self::setInspector(
			new ImposterInspector
			);
	}
}
