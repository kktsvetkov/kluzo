<?php

namespace Kluzo\Clue;

use Kluzo\Clue\ClueInterface as Clue;
use Kluzo\Clue\Declaration as DeclarationClue;
use Kluzo\Clue\MetaTrait;
use Kluzo\Kit\Trace as TraceKit;
use Exception;
use Generator;

/**
* Testimony Clue
*
* Testimony clues are used from the Inspector to report everytning that is
* logged while the application is running. They have format and label, but
* unlike the other clues, these ones have a trace and you can find where
* they originated
*/
class Testimony extends Exception implements Clue
{
	use MetaTrait;

	/**
	* @var array
	*/
	protected $things = array();

	/**
	* Constructor
	*
	* @param mixed ...$things
	*/
	function __construct(...$things)
	{
		$this->things = $things;
	}

	/**
	* Returns the meaningful parts of the trace as a clue object
	*
	* The {@link Kluzo}-related stack frames are stripped using
	* {@link Kluzo\Kit\Trace::unjunk()} and then are wrapped in a
	* new clue object
	*
	* @return Kluzo\Clue\Declaration
	*/
	function getTraceAsClue() : DeclarationClue
	{
		return new DeclarationClue(
			TraceKit::unjunk( $this->getTrace() )
			);
	}

	function getIterator() : Generator
	{
		yield from $this->things;
	}
}
