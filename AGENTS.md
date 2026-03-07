# Project Context

## Project Overview

This is the type-safe data collections library for PHP. It provides implementations for the following types of collections:
- Lists (data that has no obvious identity/primary key)
- Dictionaries (data that has a given identity/primary key)
- Indexes (dictionaries where the stored data can provide its own identity)

## Architecture & Structure

### Namespace Structure
- Root namespace: `StusDevKit\CollectionsKit`
- Test namespace: `StusDevKit\CollectionsKit\Tests\Unit`
- Test fixtures namespace: `StusDevKit\CollectionsKit\Tests\Fixtures`
- Tests mirror src directory structure under `tests/unit/src/`

### Directory Organization
- `src/` - Root source directory
- `src/Contracts/` - Interfaces and contracts
- `src/Dictionaries/` - Collections that have a given identity / primary key
- `src/Exceptions/` - Exceptions thrown by this code library
- `src/Indexes/` - Collections where the stored data provides its own identity
- `src/Lists/` - Collections that have no obvious identity / primary key
- `src/Traits/` - Code that's shared across multiple classes
- `src/Validators/` - Validation helpers used by collection classes
- `tests/fixtures/src/` - test fixtures
- `tests/unit/src/` - PHPUnit unit tests (mirrors src/ structure)

### Class Hierarchy
```
CollectionOfAnything (base class - src/CollectionOfAnything.php)
├── CollectionAsList (src/Lists/)
│   ├── ListOfCallables
│   ├── ListOfNumbers
│   │   ├── ListOfFloats
│   │   └── ListOfIntegers
│   ├── ListOfObjects
│   ├── ListOfStrings
│   └── ListOfUuids
└── CollectionAsDict (src/Dictionaries/)
    ├── DictOfBooleans
    ├── DictOfNumbers
    │   ├── DictOfFloats
    │   └── DictOfIntegers
    ├── DictOfObjects
    │   ├── DictOfUuids
    │   ├── IndexOfEntitiesWithStringIds (src/Indexes/)
    │   ├── IndexOfEntitiesWithUuids (src/Indexes/)
    │   └── IndexOfUuids (src/Indexes/)
    └── DictOfStrings
```

## Working Practices

### Before Writing Code
1. **Always ask about file placement** - Don't assume directory structure
2. **Ask about naming conventions** - Follow project patterns
3. **Check existing implementations** - Use similar classes as templates
4. **Understand the domain** - Read entity docblocks and comments
5. **Ask for further advice** - If you are not confident about your understanding, ask for more information

### Code Standards
- **PHP 8.5+** with `declare(strict_types=1)`
- **License header** - All PHP files must include the BSD-3-Clause license header (copy from any existing source file)
- **Detailed docblocks** with purpose and usage examples
- **Constructor validation** with meaningful assertions
- **Line length** - PHP docblocks and comments should word wrap at column 79. Code does not have to word wrap. Markdown files do not need to word wrap.
- **Named method parameters** - always use named method parameters when a
  method call passes more than one parameter
- **Coding standard** - Uses `LaminasCodingStandard` (see phpcs.xml.dist)
- **No naming prefixes/suffixes** - Don't use `Abstract` prefix, `Interface`
  or `Trait` suffixes (PHPStan catches misuse). Exception classes **must** end
  with the `Exception` suffix (e.g. `NullValueNotAllowedException`).

### Code Patterns

#### Section Separators
Use this pattern to organize code sections within classes:
```php
// ================================================================
//
// Section Name
//
// ----------------------------------------------------------------
```

#### Accessor Pattern (Maybe/Definite)
Use paired methods for nullable vs throwing accessors:
- `maybeFirst()` / `first()` - returns null vs throws on empty collection
- `maybeGet($key)` / `get($key)` - returns null vs throws on missing key

#### Data Transformation Methods (`apply` prefix)
Methods that transform stored data in-place must be prefixed with `apply` (e.g. `applyTrim()`, `applyLtrim()`, `applyRtrim()`). This distinguishes them from accessors and other operations. They return `static` for fluent chaining.

#### Method Chaining
Data modification methods should return `$this` or `static` for fluent chaining.

#### PHPDoc Generics
Heavy use of generics for type safety:
- `@template TKey of array-key`
- `@template TValue of mixed`
- `@extends ParentClass<TKey, TValue>`
- `@phpstan-consistent-constructor`

### Testing Practices
- **Follow ListOfStringsTest style** - Use as template for new tests
- **Test method naming** - Use snake_case: `test_can_instantiate_empty_list()`
- **Test structure**: explain test → setup → perform change → test results
- **Cover ALL public methods** including inherited ones from parent classes
- **Use TestDox attributes** for clear test descriptions
- **Comprehensive coverage** - test happy path, edge cases, and error conditions
- **Never** use for() loops in tests - always create PHPUnit data providers instead
- **Test explanations** - Keep concise, avoid redundant phrases. Word wrap at column 79.
- **Test comments** - Word wrap all test explanation comments at column 79 for readability

#### CRITICAL Testing Anti-Patterns to Avoid
- **NEVER assume the method under test works correctly** - Write tests based on what the method SHOULD do according to business requirements, not what the current implementation happens to return. Tests should reveal bugs, not encode them.
- **ALWAYS set up complete, realistic test data** - Don't use minimal parameters or default values. Understand what fields are required for valid business states and set them properly in test setup. Incomplete test objects lead to unrealistic test scenarios.
- **Define expected behavior FIRST** - Before examining the implementation,understand the business rules and define what the correct behavior should be. Then let the tests fail if the implementation is wrong, rather than tracing through buggy code to calculate test expectations.

### Task Management
- **Use TodoWrite tool** for tracking progress on multi-step tasks
- Use 'bd' for task tracking
- **Mark tasks as in_progress** when starting work
- **Mark tasks as completed** immediately when finished
- **Only one task in_progress** at a time

## Build & Test Commands

All commands run inside Docker containers. Use `DEBUG=1` prefix to enable
Xdebug.

### Setup Commands
- **Initialize environment**: `make init`
- **Open container shell**: `make shell`
- **Install dependencies**: `make composer-install`
- **Update dependencies**: `make composer-update`

### Quality Commands
- **Code formatting**: `make cs-fix`
- **Syntax checking**: `make syntax-check`
- **Static analysis**: `make phpstan` (level 10)
- **All linting**: `make static-checks` (runs syntax-check, cs-fix, phpstan)
- **All tests**: `make all-checks`

### Test Commands
- **Full test suite**: `make test`
- **Unit tests**: `make unit OPTS="specific/test/path"`
- **Code coverage**: `make coverage`

### Notes
- **Import cleanup**: Always run `make cs-fix` after import cleanup to double-check the work

## Dependencies & External Systems
- **PHPUnit 12.5** - testing framework
- **PHPStan** - static analysis at level 10 (strictest)
- **Laminas Coding Standard** - code style enforcement
- **Ramsey UUID** - for UUID v7 generation
