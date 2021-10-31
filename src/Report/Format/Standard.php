<?php

namespace Kluzo\Report\Format;

use Kluzo\Clue\ClueInterface as Clue;
use Kluzo\Clue\Testimony as TestimonyClue;
use Kluzo\Kit\Dump as DumpKit;
use Kluzo\Kit\JSON as JsonKit;
use Kluzo\Kit\Trace as TraceKit;
use Kluzo\Kit\XML as XMLKit;
use Kluzo\Report\Format\Aggregate as FormatAggregate;

use function current;
use function htmlentities;
use function is_string;
use function sprintf;

final class Standard
{
	static function loadFormats() : FormatAggregate
	{
		$aggregate = new FormatAggregate(array(
			''	=> Standard::class . '::formatDefault',
			'empty'	=> Standard::class . '::formatEmpty',
			'caller' => Standard::class . '::formatCaller',
			'assoc'	=> Standard::class . '::formatAssoc',
			'index'	=> Standard::class . '::formatIndex',
			'list'	=> Standard::class . '::formatList',
			'blooper' => Standard::class . '::formatText',
			'text'	=> Standard::class . '::formatText',
			'raw'	=> Standard::class . '::formatRaw',
			'html'	=> Standard::class . '::formatRaw',
			'table'	=> Standard::class . '::formatTable',
			'json'	=> Standard::class . '::formatToJSON',
			'unjson' => Standard::class . '::formatUnJSON',
			'dejson' => Standard::class . '::formatUnJSON',
			'xml'	=> Standard::class . '::formatXML',
		));

		return $aggregate;
	}

	static function formatEmpty(Clue $clue) : string
	{
		return '<i>empty</i>' . "\n";
	}

	static function formatDefault(Clue $clue) : string
	{
		$output = '';
		foreach ($clue as $thing)
		{
			$output .= '&#x23F5; '
				. htmlentities( DumpKit::dump($thing) );
		}

		return $output;
	}

	static function formatRaw(Clue $clue) : string
	{
		$output = '';
		foreach ($clue as $raw)
		{
			$output .= $raw . "\n";
		}

		return $output;
	}

	static function formatText(Clue $clue) : string
	{
		$output = '';
		foreach ($clue as $raw)
		{
			$output .= htmlentities($raw) . "\n";
		}

		return $output;
	}

	static function formatAssoc(Clue $clue) : string
	{
		$output = '';
		foreach ($clue as $name => $thing)
		{
			$output .= sprintf("<b><code>%s</code></b> => %s",
				htmlentities($name),
				htmlentities( DumpKit::dump($thing) )
				);
		}

		return $output;
	}

	static function formatIndex(Clue $clue, int $offset = 0) : string
	{
		$output = '';
		foreach ($clue as $index => $thing)
		{
			$output .= sprintf("<b><samp>%08d</samp></b> => %s",
				$offset + $index,
				htmlentities( DumpKit::dump($thing) )
				);
		}

		return $output;
	}

	static function formatList(Clue $clue) : string
	{
		return static::formatIndex($clue, 1);
	}

	static function formatCaller(Clue $clue) : string
	{
		$trace = current( $clue );
		$caller = current( $trace );

		return  '<blockquote class="caller">'
				. 'Called at <u>'
					. $caller['file'] . ':' . $caller['line']
					. '</u>'
				. ( (count($trace) > 1)
				 	?  '<br/>' . TraceKit::format( $trace )
					: '' )
			. '</blockquote>';
	}

	static function formatTable(Clue $clue) : string
	{
		$html = '';

		foreach ($clue as $thing)
		{
			if (!is_iterable($thing))
			{
				$html .= '&#x23F5; '
					. htmlentities( DumpKit::dump($thing) )
					. "\n";

				continue;
			}

			$columns = array();
			foreach ($thing as $row)
			{
				$columns = array_merge($columns, $row);
			}
			$columns = array_keys($columns);

			$html .= '<table border="01"><tr>';
			foreach ($columns as $column)
			{
				$html .= '<th>' . htmlentities($column) . '</th>';
			}

			$html .= '</tr>';

			foreach ($thing as $row)
			{
				$html .= '<tr>';
				foreach ($columns as $column)
				{
					$html .= '<td>'
						. htmlentities($row[ $column ] ?? '')
						. '</td>';
				}

				$html .= '</tr>';
			}

			$html .= '</table>';
		}

		return $html;
	}

	static function formatToJSON(Clue $clue) : string
	{
		$output = '';
		foreach ($clue as $thing)
		{
			$subject = is_string($thing)
				? JsonKit::unJSON( $thing )
				: $thing;

			$output .= htmlentities(
				json_encode( $subject, 192 )
				) . "\n";
		}

		return $output;
	}

	static function formatUnJSON(Clue $clue) : string
	{
		$output = '';

		foreach ($clue as $thing)
		{
			if (!is_string($thing))
			{
				$output .= DumpKit::dump($thing) . "\n";
				continue;
			}

			$subject = JsonKit::unJSON( $thing );
			$output .= DumpKit::dump( $subject ) . "\n";
		}

		return $output;
	}

	static function formatXML(Clue $clue) : string
	{
		$output = '';
		foreach ($clue as $xml)
		{
			if (!is_string( $xml ))
			{
				$output .= DumpKit::dump( $xml ) . "\n";
				continue;
			}

			$output .= htmlentities(
				XMLKit::formatXml( $xml )
				) . "\n";
		}

		return $output;
	}
}
