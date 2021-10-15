<?php

namespace Kluzo\Pocket;

use Kluzo\Pocket\PocketInterface as Pocket;
use Kluzo\Pocket\PocketFactoryInterface;
use Kluzo\Pocket\ArrayPocket;
use Kluzo\Pocket\IgnorePocket;

class PocketFactory implements PocketFactoryInterface
{
	protected $pocketCallback;

	function __construct(callable $pocketCallback)
	{
		$this->pocketCallback = $pocketCallback;
	}

	function createPocket() : Pocket
	{
		$callback = $this->pocketCallback;
		return $callback();
	}

	static function withIgnorePocket() : self
	{
		return new self(function()
		{
			return new IgnorePocket;
		});
	}

	static function withArrayPocket() : self
	{
		return new self(function()
		{
			return new ArrayPocket;
		});
	}
}
