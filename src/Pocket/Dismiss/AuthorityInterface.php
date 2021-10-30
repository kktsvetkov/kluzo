<?php

namespace Kluzo\Pocket\Dismiss;

use IteratorAggregate;

interface AuthorityInterface extends IteratorAggregate
{
	function getHTML(array $pocketNames) : string;
}
