<?php

namespace Kluzo\Disguise;

use Kluzo\Disguise\DisguiseInterface as Disguise;
use Kluzo\Pocket\SuggestedFormatInterface as PocketWithSuggestedFormat;
use Kluzo\Pocket\PocketAggregateInterface as PocketAggregate;

trait StandardDisguiseTrait
{
	function display(PocketAggregate $pocketAggregate)
	{
		static $introduced = false;
		if (!$introduced)
		{
			$this->introduceJavascript( $pocketAggregate );
			$this->introduceCSS( $pocketAggregate );

			$introduced = true;
		}

		$this->openDisplay( $pocketAggregate );
		$this->displayPockets( $pocketAggregate );
		$this->closeDisplay( $pocketAggregate );
	}

	function displayPockets(PocketAggregate $pocketAggregate) : Disguise
	{
		foreach ($pocketAggregate as $pocketName => $pocket)
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
