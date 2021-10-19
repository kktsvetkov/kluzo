<?php

namespace Kluzo\Inspector;

use Kluzo\Inspector\InspectorFactoryInterface as InspectorFactory;
use Kluzo\Inspector\InspectorFactory as InspectorAcademy;
use Kluzo\Inspector\InspectorInterface as Inspector;
use Kluzo\Inspector\LieutenantInspector;

use function strtolower;

final class ChiefInspector
{
	static private $inspectorFactory;

	static function setInspectorFactory(InspectorFactory $inspectorFactory)
	{
		self::$inspectorFactory = $inspectorFactory;
	}

	static private $inspector;

	static function getInspector() : Inspector
	{
		if (!self::$inspector)
		{
			self::$inspectorFactory = self::$inspectorFactory ??
			(
				self::$inspectorFactory = new InspectorAcademy(
					function()
					{
						return new LieutenantInspector;
					}
				)
			);

			self::$inspector = self::$inspectorFactory->createInspector();
		}

		return self::$inspector;
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
