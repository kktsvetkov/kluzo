<?php

namespace Kluzo\Pocket;

use Kluzo\Clue\ClueInterface as Clue;
use Kluzo\Disguise as InspectorDisguise;
use Kluzo\Pocket\PocketInterface as Pocket;
use Kluzo\Pocket\PocketInstructionTrait;
use Generator;

use const E_USER_WARNING;

use function iterator_count;
use function trigger_error;

class ShallowPocket implements Pocket
{
	use PocketInstructionTrait;

	protected $clue;

	function __construct(Clue $clue)
	{
		$this->clue = $clue;
		$this->with('no.index');
	}

	function put(Clue $clue) : Pocket
	{
		trigger_error(
			'You can not put clues into a shallow pocket',
			E_USER_WARNING);

		InspectorDisguise::getInspector()->log(
			'bloopers', 'Can\'t put clues in shallow pockets'
			)->setLabel('Blooper!');

		return $this;
	}

	function clean() : Pocket
	{
		trigger_error(
			'You can not clean a shallow pocket',
			E_USER_WARNING);

		InspectorDisguise::getInspector()->log(
			'bloopers', 'Can\'t clean shallow pockets'
			)->setLabel('Blooper!');

		return $this;
	}

	function getIterator() : Generator
	{
		yield $this->clue;
	}

	function count() : int
	{
		return iterator_count($this->clue);
	}
}
