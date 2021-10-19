<?php

namespace Kluzo\Inspector;

use Kluzo\Inspector\InspectorInterface as Inspector;
use Kluzo\Inspector\InspectorFactoryInterface;

class InspectorFactory implements InspectorFactoryInterface
{
	protected $callback;

	function __construct(callable $inspectorCallback)
	{
		$this->callback = $inspectorCallback;
	}

	function createInspector() : Inspector
	{
		$inspectorCallback = $this->callback;
		return $inspectorCallback();
	}
}
