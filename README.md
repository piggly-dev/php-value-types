# Values objects with based in data types

![Versão Atual](https://img.shields.io/badge/version-1.x.x-green?style=flat-square)  [![Latest Version on Packagist](https://img.shields.io/packagist/v/piggly/php-value-types.svg?style=flat-square)](https://packagist.org/packages/piggly/php-value-types) [![Packagist Downloads](https://img.shields.io/packagist/dt/piggly/php-value-types?style=flat-square)](https://packagist.org/packages/piggly/php-value-types) [![Packagist Stars](https://img.shields.io/packagist/stars/piggly/php-value-types?style=flat-square)](https://packagist.org/packages/piggly/php-value-types) [![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE) ![PHP](https://img.shields.io/packagist/php-v/piggly/php-value-types?style=flat-square)

This library was developed mainly to API systems. But, it may be applied to any systems.

## What is Value Object?

A value object is a small object that represents a simple entity whose equality is not based on identity: i.e. two value objects are equal when they have the same value, not necessarily being the same object. Examples of value objects are objects representing an amount of money or a date range. [See more](https://en.wikipedia.org/wiki/Value_object#:~:text=In%20computer%20science%2C%20a%20value,money%20or%20a%20date%20range.).

## Installation

### Composer

1. At you console, in your project folder, type `composer require piggly/php-value-types`;
2. Don't forget to add Composer's autoload file at your code base `require_once('vendor/autoload.php);`.

### Manual install

1. Download or clone with repository with `git clone https://github.com/piggly-dev/php-value-types.git`;
2. After, goes to `cd /path/to/piggly/php-value-types`;
3. Install all Composer's dependencies with `composer install`;
4. Add project's autoload file at your code base `require_once('/path/to/piggly/php-value-types/vendor/autoload.php);`.

## Dependencies 

The library has the following external dependencies:

* PHP 7.2+.

## How can it help?

Imagine an application which handle e-mails. E-mails, even with different values, have the same behavior. They have a pattern and must always be an e-mail. Across your application services, they are many entities with e-mails, such as: users, orders, companies and so on.

Without value objects you may need, in any entity which e-mails are available, checking the e-mail pattern. But, with a value object you may set this behavior and instead usign a primite type as string, you will use the `EmailType` object.

Any point of your application, it will know by all that `EmailType` handle an e-mail and always return a valid e-mail. Your business logic does not need to care about how to handle e-mails, because you `EmailType` object does.

## How this library work?

Into the API enviroment, they are lot of data we can handle. But not just the pure data, but sometimes we must check if data is filled when required or if data meets the requirements of limit, length and so on.

This library standartize different values types as objects. And any value object may have one or more assertions to be a valid data as expected by your type. This make the process of validation fast and consisious, where you API must not care about how to handle data, because values objects do.

Any value object must extends `AbstractValueType` which consist of an immutable `$value` that once is set, will never change and must be the expected value type.

The `AbstractValueType` take care of object assertions, setting a default value or convert any child class to a `string` with `__toString()` method.

## How do assertions work?

Assertions are runned by three methods: 

* `validate()`, will always return a `boolean` indicating `true` when all assertions were pass, or `false` if any assertion has failed;
* `caught()`, have the same behavior of `validate()` method, but instead of returning `false` if any assertion has failed, it will return a `string` with the message that asserting produced;
* `assert()`, will always throw an `InvalidValueTypeOfException` if any assertion fail.

You can add assertions to a value type object by using the `apply( $rule )` method. The `$rule` method, must be an object which implements `Piggly\ValueTypes\Interfaces\Validatable` or `Respect\Validation\Validatable` inteface.

By default, objects may implement assertions at `constructor` method. 

### The *required* behavior

The only assertion implemented to any `AbstractValueType` is the *required* behavior. When constructing a value type object you may set the `$required` argument as `true`. If this happen, then `AbstractValueType` will evaluate if `$value` is `null` and **required** to throw `InvalidValueTypeOfException` before any assertions, or when `$value` is `null` but **not required** will assert value stopping any other assertions.

### Assertion caching

Since a value object is immutable, the assertion must run only once. So, after run the fisrt time they are cached, and even you call any assertion method it will always return the same result.

But, there is an exception. If you apply a new assertion to the value object, it will lose cache and run only once again.

## Common Objects

Basically, the common objects take care about parsing. They will always parse any `$value` you set at `constructor` to expected data type. There are six common objects, they extends and replaces the primitive data types. See:

* `ArrayType` handle any `$value` parsing it to a valid `array` primitive type. It can handle even `JSON` strings and objects with any of following methods: `toArray()`, `toJson()` and `jsonSerialize()`;
* `BooleanType` handle any `$value` parsing it to a valid `boolean` primitive type;
* `FloatType` and `IntegerType` handle any `$value` parsing it to a valid `float` and `integer` primitive types respectively;
* `JsonType` handle any `$value` which include parsing it to a valid `JSON` into a `string` primitive type. It can handle `JSON` strings and objects with any of following methods: `toArray()`, `toJson()` and `jsonSerialize()`;
* `StringObject` handle any `$value` parsing it to a valid `string` primitive type. It will convery anything to a `string`, even objects which implements `__toString()` method or not.

The `ArrayType` and `JsonType` are the only value types that will throw an `InvalidValueTypeOfException` at `constructor` if they can't parse `value` to the expected type.

## Advanced Objects

They are self explainer, different than **Common Objects** they handle more specific behaviors and patterns. See:

* `CnhType`, expecting a Brazilian driver's license;
* `CnpjType`, expecting a Brazilian National Registry of Legal Entities (CNPJ) number;
* `CountryCodeType`, expecting a country code in ISO 3166-1 standard;
* `CpfType`, expecting a Brazillian CPF number;
* `CreditCardType`, expecting a credit card number;
* `CurrencyCodeType`, expecting an ISO 4217 currency code like GBP or EUR;
* `DateTimeType`, expecting any date time value;
* `DateType`, expecting any date value;
* `DigitsType`, expecting a `string` with only digits;
* `EmailType`, expecting an e-mail;
* `HexRgbColorType`, expecting a hexadecimal to RGB color;
* `IpType`, expecting an IP;
* `PasswordType`, expecting a password. It has enhanced behavior, see below;
* `PhoneType`, expecting a phone number;
* `PostalCodeType`, expecting a postal code;
* `SlugType`, handle any `string` value to a slug;
* `UnixTimestampType`, expecting an integer as UNIX timestamp;
* `UrlType`, expecting an URL;
* `UuidType`, expecting an UUID;
* `Uuidv1Type`, expecting an UUIDv1;
* `Uuidv3Type`, expecting an UUIDv3;
* `Uuidv4Type`, expecting an UUIDv4;
* `Uuidv5Type`, expecting an UUIDv5;
* `VersionType`, expecting a version using Semantic Versioning;

### Masking Behavior

Some **Advanced Objects** has the capability to mask its data: i.e. the `example@gmail.com` can be masked to `e******@g****.com` or `e*@g*.com`. Masked objects extends `AbstractMaskedType` and have two methods:

* `isMasked() : bool`, returning if value is masked;
* `masked( bool $keepLength = true ) : bool`, returning the masked value without mutate the original value. The `keepLength` as `true` will keep the value length as `e******@g****.com`, and as `false` will "compact" as `e*@g*.com`.

*Mask a value will never mutate the value object*. It means if you have `new EmailType('example@gmail.com.br)` and want to persist the masked value or make only the masked value available you must: `new EmailType( $emailType->masked() );`.

### Password enhanced behavior

#### Encryptation

The `PasswordType` object has and enhanced behavior. 

When constructing it, the `constructor` will evaluate if password is encrypted with `password_hash()` native function or not. When not, it will encrypt following the options set with `PasswordType::hash()` static method. By default, encryptation will use the `\PASSWORD_BCRYPT` algorithm with default options.

*After hashing, you will never ever get back the raw password*. But, you can always verify hash with the `check( $raw )` method. 

#### Strength

Otherside, still in `constructor`, it will evaluate the password strengthness with the `PasswordStrengthLib` objects and throw an `InvalidValueTypeOfException` if password does not meet the minimum strength required.

`PasswordStrengthLib` is an interface which implements:

* `strength ( $raw )`, return an `integer` between 0 and 100 indicating the password strength. Or `false`, if password does not meet requirements; 
* `getMessage ()`, may return a `string` saying why password strength has failed.

By default, there are three `libs` available in this library:

* `PasswordBasicLib`, which implements the `zxcvbn` algo;
* `PasswordCrackLib`, which uses the `cracklib-checker` command;
* `PasswordPwScoreLib`, which uses the `pwscore` command.

The `PasswordBasicLib` is applied by default to `PasswordType` object. Implementing all libs available increases the password strength checker accuracy.

## Custom Objects

You can create anytime custom objects always extending the `AbstractValueType` and preparing its own assertions.

## Samples

You can see very lightweight samples at [/samples](./samples) folder.

## Changelog

See the [CHANGELOG](CHANGELOG.md) file for information about all code changes.

## Testing the code

This library uses the PHPUnit. We carry out tests of all the main classes of this application.

```bash
vendor/bin/phpunit
```

> You must always run tests with PHP 7.2 and greater.

## Contributions

See the [CONTRIBUTING](CONTRIBUTING.md) file for information before submitting your contribution.

## Credits

- [Caique Araujo](https://github.com/caiquearaujo)
- [All contributors](../../contributors)

## Support the project

Piggly Studio is an agency located in Rio de Janeiro, Brazil. If you like this library and want to support this job, be free to donate any value to BTC wallet `3DNssbspq7dURaVQH6yBoYwW3PhsNs8dnK` ❤.

## License

MIT License (MIT). See [LICENSE](LICENSE).