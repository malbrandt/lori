# Lori

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

Library that was created in order to help Laravel's developers in their work. It's consist of a suite of usefull functions and conceptions, that can help you speed up prototyping process, optimize application performance, add more readability to your codebase etc. It supplements Laravel with missing functions, that make it an even better and convenient framework.

## Code examples
Below you can find global helper functions reference with short description and usage examples.

<table>
<thead>
    <tr>
        <td>Function</td>
        <td>Description</td>
        <td>Examples</td>
    </tr>
    <tr>
        <td>access_prop</td>
        <td>Reads or assign value for non accessible class property (private/protected).</td>
        <td>
        <pre lang="php">
// Read value of the non accessible property (private or protected).
$object = new class() { private $foo = 'bar'; };
$value = access_prop($object, 'foo'); // $value = 'bar'

// Set value to the non accessible property.
$object = new class() { protected $foo = 'bar'; };
access_prop($object, 'foo', 'biz'); // $object->foo = 'biz'
access_prop($object, 'foo', null, true); // $object->foo = null
        </pre>
        </td>
    </tr>
    <tr>
        <td>call_method</td>
        <td>Calls class method - even if it's not accessible (private/protected).</td>
        <td>
        <pre lang="php">
// Instance methods
$obj = new class() { private function foo() { return 'foo'; } };
$result = call_method('foo', $obj); // 'foo'
// Static methods
$obj = new class() { protected static function bar($args) { return $args; } };
$result = call_method('bar', $obj, [1, 2, 3]); // [1, 2, 3]
        </pre>
        </td>
    </tr>
    <tr>
        <td>caller</td>
        <td>Returns info (array) with caller info from debug_stacktrace method. Can be useful for tracing.</td>
        <td>
        <pre lang="php">
$caller = caller(); // ['file' => ..., 'line' => ..., 'class' => ..., ...] (full info from debug_stacktrace)
$caller = caller(1, 'function') // i.e. 'eval', name of function, where caller() function was called
$caller = caller(2, 'class') // specified part of caller (class), i.e. 'UserController'
$caller = caller(1, ['function', 'class']); // specified parts of caller (array), i.e. ['function' => ..., 'class' => ...]
        </pre>
        </td>
    </tr>
    <tr>
        <td>carbonize</td>
        <td>Unifies various date formats into \Illuminate\Support\Carbon object instance.</td>
        <td>
        <pre lang="php">
// Valid conversions:
$carbon = carbonize('2015-02-05');
$carbon = carbonize('2018-06-15 12:34:00');
$carbon = carbonize('first day of May 2000');
$carbon = carbonize(new \DateTime());
$carbon = carbonize(new \DateTimeImmutable());
// If conversion fails, null will be returned.
$carbon = carbonize('foobar'); // null
        </pre>
        </td>
    </tr>
    <tr>
        <td>clamp</td>
        <td>Clamps value in given range.</td>
        <td>
        <pre lang="php">
$clamped = clamp(10); // 10.0
$clamped = clamp(10, 5); // 5.0
$clamped = clamp(10, 5, 15); // 5.0
$clamped = clamp(20, 5, 15); // 15.0
        </pre>
        </td>
    </tr>
    <tr>
        <td>classify</td>
        <td>Returns type of the variable (value types) or a class name (reference types).</td>
        <td>
        <pre lang="php">
classify('1'); // 'integer'
classify('1.23'); // 'double' (or 'float', or 'real' - depends on platform)
classify([]); // 'array'
classify(new \App\User); // 'App/User' (instance passed)
classify(\App\User::class); // 'App/User' (string with FQCN passed)
classify('test'); // 'string'
        </pre>
        </td>
    </tr>
    <tr>
        <td>cli</td>
        <td>Returns console helper instance. Could be used for tracing.</td>
        <td>
        <pre lang="php">
cli()->getOutput()->writeln('foo');
cli()->getInput()->getArguments();
        </pre>
        </td>
    </tr>
    <tr>
        <td>cli_in</td>
        <td>The shortcut for `cli()->getInput()`.</td>
        <td>
        <pre lang="php">
cli_in()->getArguments();
        </pre>
        </td>
    </tr>
    <tr>
        <td>cli_out</td>
        <td>The shortcut for `cli()->getOutput()`.</td>
        <td>
        <pre lang="php">
cli_out()->writeln('bar');
        </pre>
        </td>
    </tr>
    <tr>
        <td>create_fake</td>
        <td>The shortcut for factory($class)->create()</td>
        <td>
        <pre lang="php">
// Pass model's class name:
create_fake(\App\User::class);
// Pass model's instance:
create_fake(User::inRandomOrder()->first());
// Specify number of fakes:
create_fake(\App\User::class, 3);
// Specify overrides:
create_fake(\App\User::class, 1, ['email' => 'marek.malbrandt@gmail.com']);
        </pre>
        </td>
    </tr>
    <tr>
        <td>equals</td>
        <td>Safely compares two float numbers.</td>
        <td>
        <pre lang="php">
0.1+0.1+0.1+0.1+0.1+0.1+0.1+0.1+0.1+0.1 == 1.0 // false
equals(0.1+0.1+0.1+0.1+0.1+0.1+0.1+0.1+0.1+0.1, 1.0); // true
equals(1.0, 1.0); // true
equals(2.0, 1.0); // false
        </pre>
        </td>
    </tr>
    <tr>
        <td>fileline</td>
        <td>Returns file and line number, from which the functions was called.</td>
        <td>
        <pre lang="php">
class UserController extends Controller
{
    public function foo()
    {
        fileline(); // UserController.php:5
    }
}
        </pre>
        </td>
    </tr>
    <tr>
        <td>flash_error</td>
        <td>An alias for `session()->flash('error', $msg)`.</td>
        <td>
        <pre lang="php">
flash_error('Message'); // flash error under "error" key
flash_error('Message', ['Error1', 'Error2']); // flash message and errors (under "errors" key)
flash_error('Message', null, 'user.error'); // flash message under "user.errors" key
flash_error(null, ['Error3', 'Error4'], null, 'validation.errors'); // flash message under "validation.errors" key
        </pre>
        </td>
    </tr>
    <tr>
        <td>flash_info</td>
        <td>An alias for `session()->flash('info', $msg)`.</td>
        <td>
        <pre lang="php">
flash_info('Foobar'); // flashes message under "info" key
flash_info('Foobar', 'lori.info'); // flashes message under custom key: "lori.info"
        </pre>
        </td>
    </tr>
    <tr>
        <td>flash_success</td>
        <td>An alias for `session()->flash('success', $msg)`.</td>
        <td>
        <pre lang="php">
flash_success('Foobar'); // flashes message under "success" key
flash_success('Foobar', 'lori.success'); // flashes message under custom key: "lori.success"
        </pre>
        </td>
    </tr>
    <tr>
        <td>flash_warning</td>
        <td>An alias for `session()->flash('warning', $msg)`.</td>
        <td>
        <pre lang="php">
flash_warning('Foobar'); // flashes message under "warning" key
flash_warning('Foobar', 'lori.warning'); // flashes message under custom key: "lori.warning"
        </pre>
        </td>
    </tr>
    <tr>
        <td>has_trait</td>
        <td>Examines if a class/object has given trait.</td>
        <td>
        <pre lang="php">
// Namespace omitted for readability
$obj = new class() { use ValidatesRequests; };
has_trait(ValidatesRequests::class, $obj); // true
has_trait(FooTrait::class, $obj); // false
// Using class name (we're assuming, that Controller class uses ValidatesRequest trait)
has_trait(ValidatesRequests::class, Controller::class); // true
        </pre>
        </td>
    </tr>
    <tr>
        <td>make_fake</td>
        <td>The shortcut for factory($class)->make()</td>
        <td>
        <pre lang="php">
// Pass model's class name:
make_fake(\App\User::class);
// Pass model's instance:
make_fake(User::inRandomOrder()->first());
// Specify number of fakes:
make_fake(\App\User::class, 3);
// Specify overrides:
make_fake(\App\User::class, 1, ['email' => 'marek.malbrandt@gmail.com']);
        </pre>
        </td>
    </tr>
    <tr>
        <td>method</td>
        <td>Returns caller in various useful formats.</td>
        <td>
        <pre lang="php">
method(); // caller as valid PHP callable (does not support Closures)
method(3); // caller of caller (as a callable)
method(2, METHOD_FORMAT_ACTION); // returns caller in format: FooClass@barMethod
method(2, METHOD_FORMAT_ACTION_FQCN); // returns caller in format: Class\Namespace\Foo@biz
        </pre>
        </td>
    </tr>
    <!--<tr>
        <td></td>
        <td></td>
        <td>
        <pre lang="php">
        </pre>
        </td>
    </tr>-->
</thead>
</table>

@TODO - place some examples here.

## Documentation
List of functions can be founf here (@TODO create that list). Except that, the code is well documented and contains a lot code examples. If you had any questions regarding the code, feel free to ask. The best way to do this is to find or create new topic on forum (issue with label "question" or "help needed").

## Requirements
* Laravel
* PHP

@TODO - examine exact versions

## Installation
Library can be downloaded and installed automatically using Composer.
```
composer require malbrandt/lori
```

## Tests

### Running the tests
In order to run tests, type into console:
``` bash
$ composer test
```

### Global functions
Each global function has got suite of unit tests in separate file. That files are placed in directory `app/tests/Helpers`.
In example, if a function is named `access`, test class `AccessTest` will be placed in file `app/tests/Helpers/AccessTest.php`.

### Classes
Bigger conceptions that require separate class to be implemented also have got test suites. Test files are placed in directory `tests`. Their localisation corresponds to namespaces of classes, according to PSR-4 convention. 
In example `Malbrandt/Lori/Database/Autofactory` class will have its tests in class `AutofactoryTest` in file `src/Database/AutofactoryTest.php`.

### Writing tests
For unit tests we are using PHPUnit library and Orchestra framework (@TODO provide urls).
All methods has `@test` directive in theirs PHPDocBlock.
Test method names are formuled in behavioral form, it means that they describes some feature or capabilities of some object, class or function.
Examples:
```php
/** @test */
public function retores_previous_access_modifier_after_reading_property_value() { /** … */ }

/** @test */
public function retores_previous_access_modifier_after_modifying_property_value() { /** … */ }
```

## Code style
Coding conventions are the same as in Laravel framework. The code should be written in such a way that the whole library has the minimum requirements. If you need to use function from newer Laravel version, place this information on special list: ... (@TODO: create list). Certainly your attention will be taken into account during the development of newer library's MAJOR version. Only then will we be able to use the newer version of Laravela or PHP (due to backward compatibility).

@TODO - describe StyleCI

## Contributing
If you want to add your 5 cents to this library, you can do this in many ways.
Here are few of them:
* propose change: a new function, change of some function (paremetrize its algorithm settings?), supplementing the documentation (where?), adding an example (for which function?), etc.
* if something is incomprehensible or too poorly exaplined - inform about it as fast as possible!
* take part in a discussion in existing Issue Tracker topics,
* propose interesting concept (concepts examples: batch insert, DTO, autofactories, dynamic parameters),
* deal with the function from the to-do list,
* fill in the gaps in the documentation,
* add some unusual test or test scenario,
* add code example with some function usage,
* make code review of someone changes (Pull Requests),
* write an article about some feature from this library with some great explanation of concepts and code examples (once written, link it in readme file in section `Further reading`),
* do the things TODO :)

## Versioning
This library uses [Semantic Versioning 2.0.0](https://semver.org/). We can assume that each subsequent minor version must consist of at least one new function. Any corrections (obviously compatible backwards) in the code or documentation will be included in the "patch" part of the version.

## Credits
* Marek Malbrandt - author.

## License
Copyright (c) Marek Malbrandt <marek@malbrandt.pl>

The Laravel framework is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).

@TODO - choose and describe Open Source license.

## Acknowledgements
For the creators of the Laravel framework and all libraries that were used to create this library and the libraries that these libraries use...

[ico-version]: https://img.shields.io/packagist/v/malbrandt/lori.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/malbrandt/lori.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/malbrandt/lori/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/malbrandt/lori
[link-downloads]: https://packagist.org/packages/malbrandt/lori
[link-travis]: https://travis-ci.org/malbrandt/lori
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/malbrandt

## ToDo's

### Concepts

- [ ] DTO
- [ ] CLI
- [ ] Automemoization
- [ ] Memoizaiton
- [ ] CreateOrIncrement
- [ ] CreatesReferences
- [ ] HasValidationRules
- [ ] SelectOptions
- [ ] Identifiable
- [ ] Measure
- [ ] RelativeDate
- [ ] RequestFilters
- [ ] SelectiveFind
- [ ] Service
- [ ] Url
- [ ] Str
- [ ] ValidationHelpers
- [ ] Autofactory
- [ ] Autoforms
- [ ] ArrayToExcel
- [ ] DynamicParameters
- [ ] NotImplementedException
- [ ] AutoValidation
- [ ] DisplayProgress
- [ ] BatchInsert
- [ ] GatherQueries
- [ ] MeasureResponseTimes
- [ ] RouteLocks
- [ ] RegisterRoutes
- [ ] Deferred (execution)

### Helper functions

- [x] access_prop
- [ ] batch_insert
- [x] call_method
- [x] caller
- [x] carbonize
- [x] clamp
- [x] classify
- [x] cli
- [x] cli_in
- [x] cli_out
- [x] create_fake
- [x] equals
- [x] fileline
- [x] flash_error
- [x] flash_info
- [x] flash_success
- [x] flash_warning
- [x] has_trait
- [x] make_fake
- [x] method
- [ ] on
- [ ] random_float
- [ ] register_singletons
- [ ] sometimes
- [ ] will
- [ ] will
- [ ] str_between
- [ ] to_string
- [ ] str_crop
- [ ] str_remove
- [ ] table
- [ ] trace
- [ ] testing
