<?php
namespace Piggly\ValueTypes\Advanced;

use Piggly\ValueTypes\AbstractValueType;
use Piggly\ValueTypes\Exceptions\InvalidValueTypeOfException;
use Piggly\ValueTypes\Interfaces\PasswordStrengthLib;
use Piggly\ValueTypes\Supports\PasswordBasicLib;

/**
 * Represents a password.
 *
 * @package \Piggly\ValueTypes
 * @subpackage \Piggly\ValueTypes\Advanced
 * @version 1.0.0
 * @since 1.0.0
 * @category Values
 * @author Caique Araujo <caique@piggly.com.br>
 * @author Piggly Lab <dev@piggly.com.br>
 * @license MIT
 * @copyright 2021 Piggly Lab <dev@piggly.com.br>
 */
class PasswordType extends AbstractValueType
{
	/**
	 * Password strength libs.
	 * 
	 * @var array<PasswordStrengthLib>
	 * @since 1.0.0
	 */
	static $libs = [];

	/**
	 * Password hash algoritmn settings.
	 * 
	 * @var array
	 * @since 1.0.0
	 */
	static $algo = [
		'algo' => \PASSWORD_BCRYPT,
		'options' => null
	];

	/**
	 * To measuring the password strength as
	 * assertion, it will require libraries
	 * to provide accuracy.
	 * 
	 * It is recommended all available:
	 * 
	 * PasswordType::addLib(new PasswordCrackLib())
	 * PasswordType::addLib(new PasswordPwScoreLib())
	 * 
	 * PasswordBasicLib() will be added by default
	 * and will run after all libs added.
	 *
	 * @see https://www.the-art-of-web.com/php/password-strength/
	 * @param PasswordStrengthLib $lib
	 * @since 1.0.0
	 * @return void
	 */
	public static function lib ( PasswordStrengthLib $lib )
	{ 
		if ( $lib instanceof PasswordBasicLib )
		{ return; }

		static::$libs[] = $lib; 
	}

	/**
	 * Change algo settings to hash password
	 * with password_hash function.
	 *
	 * @param integer $algo
	 * @param array $options
	 * @since 1.0.0
	 * @return void
	 */
	public static function hash (
		int $algo,
		array $options = null
	)
	{
		static::$algo = [
			'algo' => $algo,
			'options' => $options
		];
	}

	/**
	 * Constructor.
	 * 
	 * Password will accept a raw password or
	 * an encrypted one. But, when $password is
	 * raw do a runtime assertion to password
	 * strength, after encrypt it.
	 * 
	 * You will never get access back the raw
	 * password after construct this class. You
	 * may check if a raw password matches with
	 * hash by using ->check($raw) method.
	 * 
	 * The assert() method will only assert if
	 * password is set when required.
	 *
	 * @param string|null $password
	 * @param integer $minStrength Minimun strength to pass.
	 * @param mixed $default Default when $value is null.
	 * @param mixed $required If value is required.
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct ( ?string $password, int $minStrength = 75, $default = null, bool $required = false )
	{ 
		$encrypted = !empty(\password_get_info($password)['algo']);

		if ( !$encrypted )
		{
			static::$libs[] = new PasswordBasicLib();

			foreach ( static::$libs as $lib )
			{
				$strength = $lib->strength( $password );

				if ( $strength === false )
				{ throw new InvalidValueTypeOfException($this, $lib->getMessage()); }

				if ( $strength < $minStrength )
				{ throw new InvalidValueTypeOfException($this, 'password strength does not meet the minimum requirements'); }
			}
		}

		$value = \password_hash($password, static::$algo['algo'], static::$algo['options']);
		parent::__construct($value, $default, $required);
	}

	/**
	 * Check if $raw matches to current encrypted
	 * password.
	 *
	 * @param string $raw
	 * @since 1.0.0
	 * @return bool
	 */
	public function check ( string $raw ) : bool
	{ return \password_verify($raw, $this->_value); }
}