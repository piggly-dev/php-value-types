<?php
namespace Piggly\ValueTypes\Interfaces;

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