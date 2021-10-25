<?php

namespace Kluzo\Report\Format;

use Kluzo\Clue\ClueInterface as Clue;
use Kluzo\Report\Format\FormatInterface as ReportFormat;

use function htmlentities;
use function is_int;
use function iterator_count;
use function print_r;

class DefaultFormat implements ReportFormat
{
	function format(Clue $clue) : string
	{
		$clueCount = iterator_count($clue);
		switch ($clueCount)
		{
			case 0:
				return '<i>empty</i>' . "\n";
				break;

			case 1:
				foreach ($clue as $name => $thing)
				{
					if (0 === $name)
					{
						return htmlentities(
							print_r($thing, true)
							) . "\n";
						break 2;
					}
				}

			default:
				$output = '';
				foreach ($clue as $name => $thing)
				{
					$output .= is_int($name)
						? sprintf("<b><samp>%08d</samp></b> => %s\n",
							1 + $name,
							htmlentities(print_r($thing, true))
							)
						: sprintf("<b><code>%s</code></b> => %s\n",
							htmlentities($name),
							htmlentities(print_r($thing, true))
							);
				}

				return $output;
		}
	}
}
