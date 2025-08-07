# PHPStan Xefi Rules

[![CI state](https://img.shields.io/github/actions/workflow/status/xefi/phpstan-xefi-rules/tests.yml)](https://github.com/xefi/phpstan-xefi-rules)
[![Packagist version](https://img.shields.io/packagist/v/xefi/phpstan-xefi-rules)](https://packagist.org/packages/xefi/phpstan-xefi-rules)

> Some custom PHPStan extensions to improve the readability, maintainability and overall quality of your PHP code base.

Package based on PHPStan. You can find the source package [here](https://phpstan.org/).

### Supported PHP versions
| PHP version | This package version |
|-------------|----------------------|
| 7.4, 8.x    | Latest               |

## How to use it

**1**: First, you may use [Composer](https://getcomposer.org) to install this package as a development dependency into your project:

```bash
composer require --dev "xefi/phpstan-xefi-rules"
```

**2**: Then, create a `phpstan.neon` or `phpstan.neon.dist` file in the root of your application. It might look like this:

```
includes:
    - vendor/xefi/phpstan-xefi-rules/extension.neon

parameters:
    paths:
        - src/

    # 0 to 10, level 10 is the highest level
    level: 0
```

The most important part is the `includes` one, that enables the rules of this package.

For all available options, please take a look at the PHPStan documentation: **https://phpstan.org/config-reference**

**3**: Finally, you may start analyzing your code using the phpstan console command:

```bash
./vendor/bin/phpstan
```

## Rules

### Boolean Property Naming Rule

*Identifier : xefi.booleanPropertyNaming*

Ensure that a Boolean is always named with an “is” at the beginning of its name, to clarify the condition it represents.

### Max Line Per Class Rule

*Identifier : xefi.maxLinePerClass*

Guarantee that a class is no more than 100 lines long, to clearly separate roles between classes and encourage clarification.

### Max Line Per Method Rule

*Identifier : xefi.maxLinePerMethod*

Guarantee that a method is no more than 20 lines long, to separate roles between classes and encourage specification.

### No Basic Exception Rule

*Identifier : xefi.noBasicException*

Ensure that no base exceptions are thrown in order to make custom and specific exceptions everywhere for better maintainability.

### No Delete Cascade Rule (Laravel)

*Identifier : xefi.noCascadeDeleteLaravel*

Prevents cascading deletions in SQL to avoid uncontrolled deletions.  
This rule forces you to think about the need for a cascading deletion, and to handle such cases in your code if you need to, which also makes it possible to use the observers and events managed by the framework.  
  
This rule only works for Laravel.  
A Symfony rule is planned.

### No Generic Word Rule

*Identifier : xefi.noGenericWord*

Prevent generic variable names such as `array`, `string`, `str`, `result`, `res`, `data` to encourage developers to use clear and detailed names such as `users`, `filteredUsers`, `usersCount`, `cars`, ...

### No Laravel Observer Rule

*Identifier : xefi.noLaravelObserver*

Forbid the use of Observers in Laravel, as the behavior of observers is sometimes incomprehensible and uncontrollable.  
This rule encourages the use of Events & Listeners, whose behavior is similar but much more explicit and stable.

### No Try Catch Rule

*Identifier : xefi.noTryCatch*

Prevent `try catch` usage to ensure that the user uses PHP exceptions.  
This makes the code more readable and errors are handled by the framework if there is one.
