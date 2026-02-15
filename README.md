# typesafe-collections

Type-safe data collection classes for PHP 8.5+, with full PHPStan level 9 support.

## Installation

```bash
composer require stuartherbert/typesafe-collections
```

## Three Types of Collection

This library provides three types of collection, each suited to a different relationship between keys and values.

### Lists

A **List** is a sequential collection with automatic integer keys. The caller provides only values; keys are assigned automatically starting from 0.

Use a List when your data has no natural identity or primary key.

```php
use StuartHerbert\TypesafeCollections\Lists\ListOfStrings;

$tags = new ListOfStrings();
$tags->add('php')
     ->add('collections')
     ->add('typesafe');

$tags->count();      // 3
$tags->first();      // 'php'
$tags->toArray();    // [0 => 'php', 1 => 'collections', 2 => 'typesafe']
```

**Available classes:**

| Class | Description |
|-------|-------------|
| `CollectionAsList` | Base class for all lists. Extend this to create your own. |
| `ListOfNumbers` | A list of numeric values (`int` or `float`). |
| `ListOfStrings` | A list of string values. |

### Dictionaries

A **Dictionary** is a key-value collection where the caller provides both the key and the value. Use a Dictionary when your data has an external identity or when you need to control the keys.

```php
use StuartHerbert\TypesafeCollections\Dictionaries\DictOfStrings;

$config = new DictOfStrings();
$config->set('host', 'localhost')
       ->set('port', '3306');

$config->get('host');      // 'localhost'
$config->has('port');      // true
$config->maybeGet('tls');  // null
```

**Available classes:**

| Class | Description |
|-------|-------------|
| `CollectionAsDict` | Base class for all dictionaries. Extend this to create your own. |
| `DictOfStrings` | String values with arbitrary keys. |
| `DictOfBooleans` | Named boolean flags, with `isTrue()` and `isFalse()` helpers. |
| `DictOfIntegers` | Integer values with arbitrary keys. |
| `DictOfFloats` | Float values with arbitrary keys. |
| `DictOfNumbers` | Base class for numeric dictionaries. |
| `DictOfObjects` | Object values with arbitrary keys. |
| `DictOfUuids` | `UuidInterface` values with caller-provided keys. |

### Indexes

An **Index** is a key-value collection where the key is derived from the value itself. The caller provides only the value; the collection extracts the key automatically (typically from an `getId()` method).

Use an Index when your data has an inherent identity that should serve as its lookup key.

```php
use StuartHerbert\TypesafeCollections\Indexes\IndexOfEntitiesWithUuids;

$users = new IndexOfEntitiesWithUuids();
$users->add($alice);  // key derived from $alice->getId()
$users->add($bob);    // key derived from $bob->getId()

$users->get((string) $alice->getId());  // returns $alice
$users->getIds();                        // array of UuidInterface objects
```

**Available classes:**

| Class | Description |
|-------|-------------|
| `IndexOfUuids` | Bare `UuidInterface` values, keyed by their string representation. |
| `IndexOfEntitiesWithStringIds` | Entities implementing `EntityWithStringId`, keyed by `getId()`. |
| `IndexOfEntitiesWithUuids` | Entities implementing `EntityWithUuid`, keyed by `getId()`. |

## Choosing the Right Type

| Question | Use |
|----------|-----|
| Does the data have no natural key? | **List** |
| Do you want to control the key yourself? | **Dictionary** |
| Should the key come from the data itself? | **Index** |

## Common API

All three collection types share a common base (`CollectionOfAnything`) that provides:

| Method | Description |
|--------|-------------|
| `count()` | Number of items in the collection. Also works with PHP's `count()` function. |
| `empty()` | Returns `true` if the collection has no items. |
| `first()` | Returns the first item, or throws if empty. |
| `maybeFirst()` | Returns the first item, or `null` if empty. |
| `last()` | Returns the last item, or throws if empty. |
| `maybeLast()` | Returns the last item, or `null` if empty. |
| `merge()` | Merges another collection or array into this one. |
| `copy()` | Returns a new collection with the same data. |
| `toArray()` | Returns the underlying data as a plain PHP array. |
| `getIterator()` | Makes the collection iterable with `foreach`. |

Dictionaries and Indexes additionally provide:

| Method | Description |
|--------|-------------|
| `get($key)` | Returns the value for `$key`, or throws if not found. |
| `maybeGet($key)` | Returns the value for `$key`, or `null` if not found. |
| `has($key)` | Returns `true` if the key exists. |

## Contracts

The library provides interfaces for entities that can be stored in Indexes:

| Interface | Method | Use with |
|-----------|--------|----------|
| `EntityWithStringId` | `getId(): string\|Stringable` | `IndexOfEntitiesWithStringIds` |
| `EntityWithUuid` | `getId(): UuidInterface` | `IndexOfEntitiesWithUuids` |

## Extending the Library

Create your own type-safe collection by extending the appropriate base class:

```php
use StuartHerbert\TypesafeCollections\Lists\CollectionAsList;

/**
 * @extends CollectionAsList<MyValueObject>
 */
class ListOfMyValueObjects extends CollectionAsList
{
}
```

```php
use StuartHerbert\TypesafeCollections\Dictionaries\CollectionAsDict;

/**
 * @extends CollectionAsDict<string, MyEntity>
 */
class DictOfMyEntities extends CollectionAsDict
{
}
```

## License

BSD-3-Clause. See the license header in any source file for full terms.
