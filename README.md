# Kluzo PHP Debug Tool

**Kluzo PHP Debug Tool** is the PHP debugging tool with a purpose: to help you
prevent making stupid mistakes and causing accidents.

## Inspector

The Inspector object helps to collect clues and organize them in pockets. When
the script is completed, the Inspector will present a report with to collected
clues.

## Clues

Everything collected by the Inspector is stored as clues. These objects are
going to be organized in pockets and when the script is over they are going
to be included in a report.

## Pockets

Pockets collect the clues while the application is running.

## Reports

The Inspector will collect clues in pockets and at the end of the script it
must create a report and present what has been collected.

## Formats

A collection of callbacks are used to apply different formatting to the
collected clues.

## Inspector Tricks

You can add more features to your inspector by utilizing the list of Inspector
Tricks. They are a collection of callbacks bound to the Inspector object, that
you can extend and modify.

### Learning new tricks

Here is a stupid example for a new method that will append "You Fool!"

```php
kluzo::getTricks()->learnTrick('fool', function($pocketName, ...$things)
{
	$things[] = 'You Fool!';
	return $this->log($pocketName, ...$things);
});
```

That's it. The closures will be bound to the Inspector, so `$this` is going to
be the Inspector object. Once it is added, you can call it like this

```php
kluzo::fool('proba', 'I know that...');

```

And the logged details will be `array('I know that...', 'You Fool!')`.

### Forget tricks

I am not sure why, but you can also remove a trick by "forgetting" it:

```php
kluzo::getTricks()->forgetTrick('fool');
```

### "Same As" Tricks

Another thing you can do is to use several different trick names for the same
feature as some sort of alias:

```php
/* kluzo::report() will do the same as kluzo::log() */
kluzo::getTricks()->sameAs('log', 'report');
kluzo::report('proba', $proba);
```
