<?php

namespace Kluzo\Pocket\Dismiss;

use Kluzo\Pocket\Dismiss\AuthorityInterface as DismissAuthority;
use Generator;

use function array_filter;
use function strtolower;

class FixedAuthority implements DismissAuthority
{
	protected $dismissedPockets = array();

	function __construct(...$dismissedPockets)
	{
		$this->dismissedPockets = array_filter(
			$dismissedPockets,
			'strtolower'
			);
	}

	function getIterator() : Generator
	{
		yield from $this->dismissedPockets;
	}

	function getHTML(array $pocketNames) : string
	{
		$html = '<fieldset><legend>'
			. 'Here is your list of dismissed pockets'
			. '</legend>'
			. '<ul>';

		foreach ($pocketNames as $pocketName => $pocketOn)
		{
			if (!$pocketOn)
			{
				$html .= '<li>' . htmlentities($pocketName) . '</li>';
			}
		}

		$html .= '</ul></fieldset>';

		return $html;
	}
}
