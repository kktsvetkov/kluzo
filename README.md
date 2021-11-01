**NB!** *KT: I am still fiddling with this, and it is not yet stable. In other words,
the code, structure, classes and methods will likely change*

# Kluzo PHP Debug Tool

**Kluzo PHP Debug Tool** is the PHP debugging tool with a purpose: to help you
prevent making stupid mistakes and causing accidents.

**What does this library do?**

In basic terms, *the Inspector wearing Disguise collects Clues in Pockets, which
at the end are presented in a Report using different Formats.*

## Basic Use

You can take **Kluzo** as is out of the box and start using it right away.

## Advanced Use

* [Clues](docs/CLUES.md): how, where and when are clues collected
* [Pockets](docs/POCKETS.md): organizing the clues in ... well, pockets
* [Reports](docs/REPORTS.md): how the collected information are presented when the case is over
* [Formats](docs/FORMATS.md): how formatting the clues for the report works
* [Inspector](docs/INSPECTOR.md): the Inspector collects the clues in pockets, and when ready presents the report
* [Inspector Disguise](docs/DISGUISE.md): how to access the Inspector  
* [Inspector Tricks](docs/TRICKS.md): how the Inspector can learn new tricks

## Tips and Tricks

If the documentation is too big and lengthy for you, here are few tips:

- To silence Kluzo on production environments you must call `kluzo::mute()` (this
	is actually `Kluzo\Disguise::mute()`). This will replace the current
	inspector with an "Imposter" (`Kluzo\Inspector\ImposterInspector`) that
	ignores your commands and at the end of the script will not produce a report.

- You can turn on and off Kluzo while working if you want to stop it from collecting
	clues:
	* turn it ON: `kluzo::on()`, `kluzo::enable()`, `kluzo::resume()` (all aliases to `kluzo::resumeCase()`)
	* turn it OFF: `kluzo::off()`, `kluzo::disable()`, `kluzo::suspend()` (all aliases to `kluzo::suspendCase()`)
	* check is it ON: `kluzo::ison()` (alias of `kluzo::isCasesActive()`)
	* check is it ON: `kluzo::isoff()` (alias of `kluzo::isCasesSuspended()`)

- It is not recommended to rely on the ON/OFF feature if you want to
	silence Kluzo on live production environments as there might be occasional
	rogue code that turns it back on; instead it is better to use `kluzo::mute()`
