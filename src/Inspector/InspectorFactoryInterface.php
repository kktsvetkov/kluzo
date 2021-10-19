<?php

namespace Kluzo\Inspector;

use Kluzo\Inspector\InspectorInterface as Inspector;

interface InspectorFactoryInterface
{
	function createInspector() : Inspector;
}
