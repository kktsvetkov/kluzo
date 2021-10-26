<?php

namespace Kluzo\Pocket;

use Kluzo\Clue\ClueInterface as Clue;
use Kluzo\Kit\Blooper as BlooperKit;
use Kluzo\Pocket\ArrayPocket;

class LockedPocket extends ArrayPocket
{
	function __construct(...$clues)
	{
		parent::__construct(...$clues);
		$this->with('no.index', 'no.count');
	}

	function put(Clue $clue) : self
	{
		BlooperKit::log('Can\'t put clues in locked pockets');
		return $this;
	}

	function clean() : self
	{
		BlooperKit::log('Can\'t clean locked pockets');
		return $this;
	}

	function count() : int
	{
		return 0;
	}
}
