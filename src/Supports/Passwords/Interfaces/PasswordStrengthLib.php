<?php
namespace Piggly\ValueTypes\Supports\Passwords\Interfaces;

/**
 * Represents a password strength lib object. 
 * 
 * All libs must test the password strongness
 * with a score between 0 and 100, or return
 * FALSE if password does not match the basics
 * requirements.
 * 
 * When FALSE, it also may provide a friendly
 * message with the getMessage() method or, if
 * don't, must always return null.
 * 
 * @package \Piggly\ValueTypes
 * @subpackage \Piggly\ValueTypes\Supports\Passwords\Interfaces
 * @version 1.0.0
 * @since 1.0.0
 * @category Passwords
 * @author Caique Araujo <caique@piggly.com.br>
 * @author Piggly Lab <dev@piggly.com.br>
 * @license MIT
 * @copyright 2021 Piggly Lab <dev@piggly.com.br>
 */
interface PasswordStrengthLib
{
	/**
	 * Must return an integer between
	 * 0 and 100 indicating the password
	 * strength.
	 * 
	 * Or FALSE, if password does not meet
	 * requirements. In this case, method
	 * getMessage() must return a message
	 * with requirements context.
	 *
	 * @param string $raw
	 * @since 1.0.0
	 * @return int|bool
	 */
	public function strength ( $raw );

	/**
	 * May return a support message when
	 * password does not meet requirements
	 * after executing strength() method.
	 *
	 * @since 1.0.0
	 * @return string|null
	 */
	public function getMessage () : ?string;
}