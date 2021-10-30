<?php

namespace Kluzo\Pocket\Dismiss;

use Kluzo\Pocket\Dismiss\FixedAuthority;

use function array_merge;
use function explode;
use function htmlentities;
use function in_array;
use function strtolower;
use function uniqid;

class CookieAuthority extends FixedAuthority
{
	protected $dismissedCookieName = 'kluzo_dismiss';

	protected $skip = array('settings', 'bloopers');

	function __construct(string $cookieName = null, array $skip = null)
	{
		if ($cookieName)
		{
			$this->dismissedCookieName = $cookieName;
		}

		if ($skip)
		{
			$this->skip = array_merge($this->skip, $skip);
		}


		$dismissedPockets = $this->readDisabledPockets();
		parent::__construct(... $dismissedPockets);
	}

	function readDisabledPockets() : array
	{
		$cookieValue = $_COOKIE[ $this->dismissedCookieName ] ?? '';
		return explode(',', $cookieValue);
	}

	function getHTML(array $pocketNames) : string
	{
		$html = '<fieldset><legend>'
			. 'Unselect all pockets you want to hide'
			. '</legend>';

		$functionName = 'kluzo_dismiss_' . uniqid();
		$cookieId = urlencode( $this->dismissedCookieName );

		$html .= '<script>'
			. 'function ' . $functionName . '(input)'
			. '{'
				. 'var disabled = "";'
				. 'input.parentNode.parentNode.querySelectorAll('
					. '"input[name=\'' . $cookieId . '\']"'
				. ').forEach(function(checkbox)'
			. '{'
				. 'if (!checkbox.checked)'
				. '{'
					. 'disabled += (disabled ? "," : "")'
						. '+ encodeURIComponent(checkbox.value);'
				. '}'
			. '});'

			. 'document.cookie = "' . $cookieId . '=" + disabled;'
			. '}'
			. '</script>';

		foreach ($pocketNames as $pocketName => $pocketOn)
		{
			if (in_array($pocketName, $this->skip))
			{
				continue;
			}

			$pocketId = htmlentities($pocketName);

			$html .= '<br/><label><input name="kluzo_dismiss" '
				. ' value="' . $pocketId . '" '
				. ' type="checkbox" '
				. (($pocketOn)
					? ' checked="checked" '
					: '')
				. ' onChange="' . $functionName . '(this)" />'
				. $pocketId
				. '</label>';
		}

		$html .= '</fieldset>';

		return $html;
	}
}
