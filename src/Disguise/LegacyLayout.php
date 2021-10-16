<?php

namespace Kluzo\Disguise;

use Kluzo\Inspector;
use Kluzo\Disguise\DisguiseInterface as Disguise;
use Kluzo\Disguise\StandardDisguiseInterface as StandardDisguise;
use Kluzo\Disguise\StandardDisguiseTrait;
use Kluzo\Pocket\PocketInterface as Pocket;
use Countable;

use function htmlentities;
use function iterator_to_array;
use function print_r;
use function shuffle;

use function current;
use function next;
use function reset;

class LegacyLayout implements StandardDisguise
{
	use StandardDisguiseTrait;

	function openDisplay(Inspector $inspector) : Disguise
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
		foreach ($inspector as $pocketName => $pocket)
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

	function closeDisplay(Inspector $inspector) : Disguise
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

	function displayPocket(string $pocketName, Pocket $pocket, array $formats) : Disguise
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

		$this->formatDisplay($pocket, $formats);
		echo '</div>', '</pre>';

		return $this;
	}

	protected function formatDisplay(Pocket $pocket, array $formats)
	{
		foreach ($formats as $format)
		{
			switch ($format)
			{
				// case 'long_list':
				//
				// case 'mixed_list':
				// 	return $this->formatMixedList($pocket);

				case 'array_dump':
					return $this->formatDefault($pocket);
			}
		}

		return $this->formatDefault($pocket);
	}

	// protected function formatMixedList(Pocket $pocket)
	// {
	// 	var_dump($pocket);
	// }

	protected function formatDefault(Pocket $pocket)
	{
		echo htmlentities(
			print_r( iterator_to_array($pocket), true )
			);
	}

	function introduceJavascript(Inspector $inspector) : Disguise
	{
		$pockets = iterator_to_array( $inspector );

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

	function introduceCSS(Inspector $inspector) : Disguise
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
