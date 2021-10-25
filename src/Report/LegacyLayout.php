<?php

namespace Kluzo\Report;

use Kluzo\Clue\ClueInterface as Clue;
use Kluzo\Clue\Testimony as TestimonyClue;
use Kluzo\Pocket\PocketInterface as Pocket;
use Kluzo\Pocket\PocketAggregateInterface as PocketAggregate;
use Kluzo\Report\AbstractPrintReport as PrintReport;
use Kluzo\Report\Format\Register as FormatRegister;

use function htmlentities;
use function iterator_count;
use function mt_srand;
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
			$cluesCount = $pocket->count();

			echo ' <a onClick="return debug_select(this);" id="tab-',
				$pocketTab, '" href="#debug-',
				$pocketTab, '">',
				$pocketTab,
				((!$pocket->is('no.count')) ? " ({$cluesCount})" : ''),
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

	/**
	* Pick randome color for tab backgrounds
	*
	* @return string
	*/
	protected function pickTabColor() : string
	{
		static $colors;
		if (empty($colors))
		{
			$colors = self::POCKET_COLORS;
			mt_srand();
			shuffle($colors);
		}
		if (false === next($colors))
		{
			reset($colors);
		}

		return current($colors);
	}

	function displayPocket(string $pocketName, Pocket $pocket) : self
	{
		$pocketTab = htmlentities( $pocketName );
		echo '<a name="debug-', $pocketTab, '"></a>',
			'<pre id="debug-', $pocketTab, '" style="background: ',
				$this->pickTabColor(), '">',
			'<div style="direction: ltr;">';

		$showIndex = !$pocket->is('no.index');
		foreach ($pocket as $i => $clue)
		{
			// put dividers between clues
			//
			if ($i > 0 )
			{
				echo '<br />',
					'<hr style="opacity:20%" />',
					'<br />';
			}

			// show index
			//
			if ($showIndex)
			{
				echo '<small class="clue-index">',
					sprintf('%06d.', 1 + $i),
					'</small> ';
			}

			$this->displayClue($clue);
		}

		echo '</div>', '</pre>';

		return $this;
	}

	protected function displayClue(Clue $clue) : self
	{
		if ($label = $clue->getLabel())
		{
			echo '<strong class="clue-label">',
				htmlentities($label),
				'</strong> ';
		}

		echo '<span class="clue">', "\n\n";

		echo FormatRegister::getFormat()->format($clue);

		if ($clue instanceOf TestimonyClue)
		{
			$this->displayCaller($clue);
		}

		echo '</span>';
		return $this;
	}

	protected function displayCaller(TestimonyClue $clue) : self
	{
		echo '<blockquote class="caller">',
			'Called at <u>', $clue->getFile(),
			':', $clue->getLine(),
			'</u>', '<br/>', $clue->getTraceAsString(),
			'</blockquote>';

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
		'.kluzo-debug-bar .clue blockquote.caller {',
			'margin: 1.5em .25em 0;',
			'padding-left:.5em;',
			'border-left: solid 3px #fff;',
		'}',
		'.kluzo-debug-bar > pre .clue-label {',
			'background: white;',
			'color: black;',
			'padding: 0 .25em;',
			'box-shadow: 2px 2px black;',
		'}',
		'.kluzo-debug-bar > pre small.clue-index {',
			'opacity: 50%;',
			'color: khaki;',
		'}',
		'.kluzo-debug-bar > pre .clue b > samp {',
			'color:#fff;',
			'background:#000;',
			'line-height:.8em;',
			'font-size:.8em;',
			'padding: 0 .2em;',
		'}',
		'.kluzo-debug-bar > pre .clue b > code {',
			'color: orange;',
			'background:transparent;',
			'border: 0;',
			'padding: 0;',
		'}',
		'</style>';

		return $this;
	}

}
