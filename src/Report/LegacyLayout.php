<?php

namespace Kluzo\Report;

use Kluzo\Clue\ClueInterface as Clue;
use Kluzo\Clue\Testimony as TestimonyClue;
use Kluzo\Pocket\PocketInterface as Pocket;
use Kluzo\Pocket\PocketAggregateInterface as PocketAggregate;
use Kluzo\Report\AbstractPrintReport as PrintReport;

use function htmlentities;
use function iterator_to_array;
use function print_r;
use function shuffle;

use function current;
use function next;
use function reset;

class LegacyLayout extends PrintReport
{
	function openDisplay(PocketAggregate $pocketAggregate) : self
	{
		echo '<div class="kluzo-debug-bar">';

		echo '<div class="bar">',
			'<span class="ladybug">',
				'<a target="_blank" href="https://github.com/kktsvetkov/kluzo">',
					'<b>Kluzo!</b>',
				'</a> ',
				'(', date('Y-m-d H:i:s O'), ')',
				'<a onClick="this.parentNode.parentNode.parentNode.remove()">&times;</a> ',
			'</span>';

		echo '<div class="tabs">';
		foreach ($pocketAggregate as $pocketName => $pocket)
		{
			$pocketTab = htmlentities($pocketName);

			$thingsCount = ($pocket instanceOf Countable)
				? $pocket->count()
				: null;

			echo ' <a onClick="return debug_select(this);" id="tab-',
				$pocketTab, '" href="#debug-',
				$pocketTab, '">',
				$pocketTab,
				((2 <= $thingsCount) ? " ({$thingsCount})" : ''),
				'</a>';
		}

		echo '</div>', '<div style="clear:both;"></div>', '</div>';

		return $this;
	}

	function closeDisplay(PocketAggregate $pocketAggregate) : self
	{
		echo '</div>';
		return $this;
	}

	const POCKET_COLORS = array(
		'#3b6b4c',
		'#302c2c',
		'#6e3f30',
		'#476f72'
		);

	function displayPocket(string $pocketName, Pocket $pocket, array $formats) : self
	{
		// pick random background color
		//
		static $colors;
		if (empty($colors))
		{
			$colors = self::POCKET_COLORS;
			shuffle($colors);
		}
		if (false === next($colors))
		{
			reset($colors);
		}

		$pocketTab = htmlentities( $pocketName );
		echo '<a name="debug-', $pocketTab, '"></a>',
			'<pre id="debug-', $pocketTab, '" style="background: ',
				current( $colors ), '">',
			'<div style="direction: ltr;">';

		foreach ($pocket as $i => $clue)
		{
			if ($i > 0)
			{
				echo '<br />',
					'<hr style="opacity:20%" />',
					'<br />';
			}

			// printf('%05d. ', 1 + $i);

			$this->displayClue($clue, $formats);
		}

		echo '</div>', '</pre>';

		return $this;
	}

	protected function displayClue(Clue $clue, array $formats) : self
	{
		if ($label = $clue->getLabel())
		{
			echo '<strong class="clue-label" ',
				'style="background: white; color: black;">',
				$label, '</strong> ';
		}

		echo '<span class="clue">';
		$clueCount = iterator_count($clue);
		if (1 === $clueCount)
		{
			$things = iterator_to_array($clue);
			$output = print_r(
				isset($things[0])
					? $things[0]
					: $things, true);
			echo htmlentities($output);
		} else
		if ($clueCount > 1024)
		{
			foreach ($clue as $name => $thing)
			{
				$output = print_r([$name => $thing], true);
				echo htmlentities($output);
			}
		} else
		{
			$things = iterator_to_array($clue);
			$output = print_r($things, true);
			echo htmlentities($output);
		}

		if ($clue instanceOf TestimonyClue)
		{
			echo '<blockquote style="margin: .25em; padding-left:.5em; border-left: solid 3px white;">',
				'Called at <u>', $clue->getFile(),
				':', $clue->getLine(),
				'</u>', '<br/>', $clue->getTraceAsString(),
				'</blockquote>';
		}

		echo '</span>';
		return $this;
	}

	function introduceJavascript(PocketAggregate $pocketAggregate) : self
	{
		$pockets = iterator_to_array( $pocketAggregate );

		echo '<script type="text/javascript">',
		'function debug_select(el)',
		'{',
			'var pockets = ', json_encode( array_keys($pockets) ), ';',
			'for (var i = 0; i < pockets.length; i++)',
			'{',
				'var tab = document.getElementById("tab-" + pockets[i]);',
				'var debug = document.getElementById("debug-" + pockets[i]);',
				'if (!tab || !debug) continue;',

				'var color = "#ccc", display = "none";',
				'if (el.id == ("tab-" + pockets[i]))',
				'{',
					'if (debug.style.display != "block")',
					'{',
						'color = "#fff";',
						'display = "block";',
					'}',
				'}',

				'tab.style.color = color;',
				'debug.style.display = display;',
			'}',

			'return false;',
		'}',
		'</script>';

		return $this;
	}

	function introduceCSS(PocketAggregate $pocketAggregate) : self
	{
		echo '<style>',
		'.kluzo-debug-bar {',
			'text-align: center;',
			'font: 12px Arial, Helvetica, Verdana, sans-serif;',
			'clear:both;',
		'}',
		'.kluzo-debug-bar .bar {',
			'margin: 0;',
			'cursor: default;',
			'background: black;',
			'color: #aaa;',
			'padding: .5em;',
			'min-height: 1.25em;',
		'}',
		'@media only screen and (min-width: 1280px) {',
			'.kluzo-debug-bar .bar {',
				'zoom: 120%;',
				'border-top: solid 3px #3c4249;',
			'}',
		'}',
		'.kluzo-debug-bar .bar .ladybug {',
			'float: right;',
			'background-image: url(//pixeljoint.com/files/icons/m.ico.gif);',
			'background-repeat: no-repeat;',
			'background-position: center left;',
			'padding-left: 1em;',
		'}',
		'.kluzo-debug-bar .bar .ladybug a {',
			'margin-left: .5em;',
			'text-decoration: none;',
			'cursor: pointer;',
		'}',
		'.kluzo-debug-bar .bar .ladybug a b {',
			'color: khaki;',
			'font-weight: bold;',
		'}',
		'.kluzo-debug-bar .bar .tabs {',
			'float: left;',
		'}',
		'.kluzo-debug-bar .bar .tabs a {',
			'cursor: pointer;',
			'text-transform: capitalize;',
			'color: #ccc;',
			'text-decoration: none;',
			'margin: 0 0 0 .15em;',
		'}',
		'.kluzo-debug-bar .bar .tabs a:not(:first-child)::before {',
			'content: "|";',
			'color: #666;',
			'margin-right: .45em;',
		'}',
		'.kluzo-debug-bar > pre {',
			'text-align: left;',
			'overflow:scroll;',
			'background: navy;',
			'color:white;',
			'padding: 1em;',
			'margin:0;',
			'height:400px;',
			'direction: rtl;',
			'font: 10pt Courier;',
			'display: none;',
			'white-space:pre;',
		'}',
		'</style>';

		return $this;
	}

}
