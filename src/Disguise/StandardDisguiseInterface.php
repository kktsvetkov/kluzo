<?php

namespace Kluzo\Disguise;

use Kluzo\Inspector;
use Kluzo\Disguise\DisguiseInterface as Disguise;
use Kluzo\Pocket\PocketInterface as Pocket;

interface StandardDisguiseInterface extends Disguise
{
	function displayPockets(Inspector $inspector) : Disguise;
	function displayPocket(string $pocketName, Pocket $pocket, array $formats) : Disguise;

	function openDisplay(Inspector $inspector) : Disguise;
	function closeDisplay(Inspector $inspector) : Disguise;

	function introduceJavascript(Inspector $inspector) : Disguise;
	function introduceCSS(Inspector $inspector) : Disguise;
}
