<?php

namespace Kluzo\Kit;

use const DEBUG_BACKTRACE_IGNORE_ARGS;

use function debug_backtrace;
use function sprintf;

class Trace
{
	static function getTraceBack() : string
	{
		$backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
		array_shift($backtrace);
		array_shift($backtrace);

		$trace = '';
		foreach ($backtrace as $i => $stackFrame)
		{
			$trace .= "\n" . sprintf('#%02d ', $i++)
				. (!empty($stackFrame['class'])
					? "{$stackFrame['class']}{$stackFrame['type']}"
					: '')
				. "{$stackFrame['function']}()";

			if (!empty($stackFrame['file']) and !empty($stackFrame['line']))
			{
				$trace .= " at {$stackFrame['file']}:{$stackFrame['line']}";
			}
		}

		return $trace;
	}
}
