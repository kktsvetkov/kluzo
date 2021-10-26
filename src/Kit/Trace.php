<?php

namespace Kluzo\Kit;

use function array_filter;
use function sprintf;

class Trace
{
	static function unjunk(array $trace) : array
	{
		$last = null;
		foreach ($trace as $index => &$frame)
		{
			if (empty($frame['class']))
			{
				continue;
			}

			if (0 !== strpos($frame['class'], 'Kluzo\\'))
			{
				continue;
			}

			// leave last one but clean it
			//
			if (\Kluzo\Disguise::class === $frame['class']
				&& ('__callStatic' === $frame['function']))
			{
				$frame['function'] = $last['function'];
				continue;
			}

			$last = $frame;
			unset($trace[ $index ]);
		}

		return $trace;
	}

	static function format(array $trace) : string
	{
		$index = 0;
		$backtrace = '';

		foreach ($trace as $frame)
		{
			$backtrace .= sprintf('#%02d ', ++$index)
				. (!empty($frame['class'])
					? "{$frame['class']}{$frame['type']}"
					: '')
				. "{$frame['function']}()";

			if (!empty($frame['file']) and !empty($frame['line']))
			{
				$backtrace .= " at {$frame['file']}:{$frame['line']}";
			}

			$backtrace .= "\n";
		}

		return $backtrace;
	}
}
