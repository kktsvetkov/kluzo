<?php

namespace Kluzo\Disguise;

use Kluzo\Disguise\DisguiseInterface as Disguise;
use Kluzo\Pocket\PocketInterface as Pocket;
use Kluzo\Pocket\PocketAggregateInterface as PocketAggregate;

interface StandardDisguiseInterface extends Disguise
{
	function displayPockets(PocketAggregate $pocketAggregate) : Disguise;
	function displayPocket(string $pocketName, Pocket $pocket, array $formats) : Disguise;

	function openDisplay(PocketAggregate $pocketAggregate) : Disguise;
	function closeDisplay(PocketAggregate $pocketAggregate) : Disguise;

	function introduceJavascript(PocketAggregate $pocketAggregate) : Disguise;
	function introduceCSS(PocketAggregate $pocketAggregate) : Disguise;
}
