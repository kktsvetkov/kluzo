<?php

namespace Kluzo\Disguise;

use Kluzo\Inspector;
use Kluzo\Disguise\DisguiseInterface as Disguise;
use Kluzo\Pocket\SuggestedFormatInterface as PocketWithSuggestedFormat;

trait StandardDisguiseTrait
{
	function display(Inspector $inspector)
	{
		static $introduced = false;
		if (!$introduced)
		{
			$this->introduceJavascript( $inspector );
			$this->introduceCSS( $inspector );

			$introduced = true;
		}

		$this->openDisplay( $inspector );
		$this->displayPockets( $inspector );
		$this->closeDisplay( $inspector );
	}

	function displayPockets(Inspector $inspector) : Disguise
	{
		foreach ($inspector as $pocketName => $pocket)
		{
			$formats = [$pocketName];
			if ($pocket instanceOf PocketWithSuggestedFormat)
			{
				$formats[] = $pocket->suggestFormat();
			}

			$this->displayPocket($pocketName, $pocket, $formats);
		}

		return $this;
	}
}
