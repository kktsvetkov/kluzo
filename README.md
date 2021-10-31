# Kluzo PHP Debug Tool

**Kluzo PHP Debug Tool** is the PHP debugging tool with a purpose: to help you
prevent making stupid mistakes and causing accidents.

## Inspector Tricks

You can add more features to your inspector by utilizing the list of Inspector
Tricks. They are a collection of callbacks bound to the Inspector object, that
you can extend and modify.

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

I am not sure why, but you can also remove a trick by "forgetting" it:

```php
kluzo::getTricks()->forgetTrick('fool');
```

Another thing you can do is to use several different trick names for the same
feature as some sort of alias:

```php
/* kluzo::report() will do the same as kluzo::log() */
kluzo::getTricks()->sameAs('log', 'report');
kluzo::report('proba', $proba);
```
