<?php

namespace Kluzo;

use Kluzo\Kit\Blooper as BlooperKit;
use Kluzo\Inspector\AbstractInspector as Inspector;
use Closure;
use Generator;
use IteratorAggregate;

use function is_callable;
use function strtolower;

final class Tricks implements IteratorAggregate
{
	protected $inspector;

	function __construct(Inspector $inspector)
	{
		$this->inspector = $inspector;
		$this->oldTricks();
	}

	protected $tricks = array();

	function knownTrick(string $trickName) : bool
	{
		$trickName = strtolower( $trickName );
		if (!empty( $this->tricks[ $trickName ] ))
		{
			return true;
		}

		if (is_callable(array( $this->inspector, $trickName)))
		{
			$this->tricks[ $trickName ] = array($this->inspector, $trickName);
			return true;
		}

		return false;
	}

	function learnTrick(string $trickName, callable $trick) : self
	{
		$trickName = strtolower( $trickName );
		$this->tricks[ $trickName ] = $trick;

		return $this;
	}

	function forgetTrick(string $trickName) : self
	{
		$trickName = strtolower( $trickName );
		unset( $this->tricks[ $trickName ] );

		return $this;
	}

	function sameAs(string $trickName, string $aliasName) : self
	{
		if (!$this->knownTrick($trickName))
		{
			BlooperKit::log( "Missing trick {$trickName}()" );
			return $this;
		}

		$trickName = strtolower( $trickName );
		$aliasName = strtolower( $aliasName );

		return $this->learnTrick($aliasName, $this->tricks[ $trickName ]);
	}

	function getIterator() : Generator
	{
		yield from $this->tricks;
	}

	function __call(string $trickName, array $arguments)
	{
		if (!$this->knownTrick($trickName))
		{
			BlooperKit::log( "Unknown trick {$trickName}()" );
			return $this->inspector;
		}

		$trickName = strtolower( $trickName );
		$trick = $this->tricks[ $trickName ];

		if ($trick instanceOf Closure)
		{
			return ($trick->bindTo($this->inspector))(...$arguments);
		}

		return $trick(...$arguments);
	}

	protected function oldTricks()
	{
		$this->tricks['ison'] = array($this->inspector, 'isCaseActive');
		$this->tricks['isoff'] = array($this->inspector, 'isCaseSuspended');

		$this->tricks['on'] = array($this->inspector, 'resumeCase');
		$this->tricks['off'] = array($this->inspector, 'suspendCase');
		$this->tricks['enable'] = array($this->inspector, 'resumeCase');
		$this->tricks['disable'] = array($this->inspector, 'suspendCase');

		$this->tricks['allow'] = array($this->inspector, 'unblockPocket');
		$this->tricks['ban'] = array($this->inspector, 'blockPocket');

		$this->tricks['clear'] = array($this->inspector, 'cleanPocket');
		$this->tricks['clean'] = array($this->inspector, 'cleanPocket');

		$this->tricks['miss'] = function(string $pocketName, ...$things)
		{
			return $this->log($pocketName, ...$things)->formatAs('miss');
		};

		$this->tricks['html'] = function(string $pocketName, ...$things)
		{
			return $this->log($pocketName, ...$things)->formatAs('html');
		};

		$this->tricks['text'] = function(string $pocketName, ...$things)
		{
			return $this->log($pocketName, ...$things)->formatAs('text');
		};
	}
}
