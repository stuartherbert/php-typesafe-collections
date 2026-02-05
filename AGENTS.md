# Project Context

## Project Overview

This is the type-safe data collections library for PHP. It handles two types of collections:
- Lists (data that has no obvious identity/primary key)
- Sets (data that has a given identity/primary key)

## Architecture & Structure

### Namespace Structure
- Root namespace: `StuartHerbert\TypesafeCollections`
- Test namespace: `StuartHerbert\TypesafeCollections\Tests\Unit`
- Tests mirror src directory structure under `tests/unit/src/`

### Directory Organization
- `src/` - Root source directory
- `src/Contracts/` - Interfaces and contracts
- `src/Exceptions/` - Exceptions thrown by this code library
- `src/Lists/` - Collections that have no obvious identity / primary key
- `src/Sets/` - Collections that have a given identity / primary key
- `tests/unit/src/` - PHPUnit unit tests (mirrors src/ structure)

### Class Hierarchy
```
CollectionOfAnything (base class - src/CollectionOfAnything.php)
├── CollectionAsList (for Lists - src/Lists/)
│   └── ListOfStrings
└── CollectionAsSet (for Sets - src/Sets/)
    ├── SetOfStrings
    ├── SetOfBooleans
    └── SetOfObjects
        └── SetOfUuids
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
  or `Trait` suffixes (PHPStan catches misuse)

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
- **Static analysis**: `make phpstan` (level 9)
- **All linting**: `make lint` (runs syntax-check, cs-fix, phpstan)

### Test Commands
- **Full test suite**: `make test`
- **Unit tests**: `make unit OPTS="specific/test/path"`
- **Code coverage**: `make coverage`

### Notes
- **Import cleanup**: Always run `make cs-fix` after import cleanup to double-check the work

## Dependencies & External Systems
- **PHPUnit 12.5** - testing framework
- **PHPStan** - static analysis at level 9 (strictest)
- **Laminas Coding Standard** - code style enforcement
- **Ramsey UUID** - for UUID v7 generation

## Landing the Plane (Session Completion)

**When ending a work session**, you MUST complete ALL steps below. Work is NOT complete until `git push` succeeds.

**MANDATORY WORKFLOW:**

1. **File issues for remaining work** - Create issues for anything that needs follow-up
2. **Run quality gates** (if code changed) - Tests, linters, builds
3. **Update issue status** - Close finished work, update in-progress items
4. **PUSH TO REMOTE** - This is MANDATORY:
   ```bash
   git pull --rebase
   bd sync
   git push
   git status  # MUST show "up to date with origin"
   ```
5. **Clean up** - Clear stashes, prune remote branches
6. **Verify** - All changes committed AND pushed
7. **Hand off** - Provide context for next session

**CRITICAL RULES:**
- Work is NOT complete until `git push` succeeds
- NEVER stop before pushing - that leaves work stranded locally
- NEVER say "ready to push when you are" - YOU must push
- If push fails, resolve and retry until it succeeds
