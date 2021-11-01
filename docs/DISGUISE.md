# Kluzo PHP Debug Tool: Advanced Topics

Learn more about the Inspector Disguise...

## Disguise

The `Kluzo\Disguise` class is what actually you are interacting with when you
work with the library.

It is a static proxy that wraps the [Inspector](INSPECTOR.md) object, and hosts
the list of [Inspector Tricks](TRICKS.md). There is a class alias created for
`Kluzo\Disguise` called `kluzo` and this is what you are going to be using
most of the time:

```php
kluzo::log('discounts', $discountValue, $originalPrice);
kluzo::json('logs', $payload);
...
```

The static proxy will make it easier to call Kluzo from wherever within your code.

### Get the current Inspector

You can get the current Inspector by calling `Kluzo\Disguise::getInspector()`:

```php
kluzo::getInspector()->closeCase(); // ends up Kluzo's work prematurely
```

## Change the Inspector

It will not happen often (if any), but you can swap your Inspector objects using
`Kluzo\Disguise::setInspector()`:

```php
use App\MyOwnInspector;
kluzo::setInspector( new MyOwnInspector );
```

There is an Inspector class declared by default, `Kluzo\Inspector\ChiefInspector`.
It comes with few pockets, such as "Request", "Session", "Server" and "Files".

## Silence Kluzo

It goes without saying that that Kluzo should stay silened on live production
environments. To do this, use `kluzo::mute()` (this is actually
`Kluzo\Disguise::mute()`). What this does is it will replace the current
inspector with an "Imposter" (`Kluzo\Inspector\ImposterInspector`) that
ignores your commands and at the end of the script will not produce a report.

```php
if (!app()->environment('local', 'staging'))
{
	kluzo::mute();
}
```

## Inspector Tricks

To get the list of [Inspector Tricks](TRICKS.md), you can call `kluzo::getTricks()`
(that is actually `Kluzo\Disguise::getTricks()`).

Here is the same stupid example as used in the Tricks documentation:

```php 
kluzo::getTricks()->learnTrick('fool', function($pocketName, ...$things)
{
	$things[] = 'You Fool!';
	return $this->log($pocketName, ...$things);
});
```
