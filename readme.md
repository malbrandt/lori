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
$object = new class { private $foo = 'bar'; };
$value = access_prop($object, 'foo'); // $value = 'bar'

// Set value to the non accessible property.
$object = new class { protected $foo = 'bar'; };
access_prop($object, 'foo', 'biz'); // $object->foo = 'biz'
access_prop($object, 'foo', null, true); // $object->foo = null
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
- [ ] call_method
- [x] caller
- [ ] carbonize
- [ ] clamp
- [x] classify
- [ ] cli
- [ ] cli_in
- [ ] cli_out
- [ ] create_fake
- [ ] equals
- [ ] was
- [ ] fileline
- [ ] flash_error
- [ ] flash_info
- [ ] flash_success
- [ ] flash_warning
- [ ] has_trait
- [ ] make_fake
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
