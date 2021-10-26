<?php

namespace Kluzo\Pocket;

use Kluzo\Clue\ClueInterface as Clue;
use Kluzo\Disguise as InspectorDisguise;
use Kluzo\Pocket\ArrayPocket;
use Kluzo\Pocket\PocketInterface as Pocket;
use Generator;

use const E_USER_WARNING;

use function iterator_count;
use function trigger_error;

class LockedPocket extends ArrayPocket
{
	function __construct(...$clues)
	{
		parent::__construct(...$clues);
		$this->with('no.index', 'no.count');
	}

	function put(Clue $clue) : Pocket
	{
		trigger_error(
			'You can not put clues into a locked pocket',
			E_USER_WARNING);

		InspectorDisguise::getInspector()->log(
			'bloopers', 'Can\'t put clues in locked pockets'
			)->setLabel('Blooper!');

		return $this;
	}

	function clean() : Pocket
	{
		trigger_error(
			'You can not clean a locked pocket',
			E_USER_WARNING);

		InspectorDisguise::getInspector()->log(
			'bloopers', 'Can\'t clean locked pockets'
			)->setLabel('Blooper!');

		return $this;
	}

	function count() : int
	{
		return 0;
	}
}
