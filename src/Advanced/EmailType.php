<?php
namespace Piggly\ValueTypes\Advanced;

use Piggly\ValueTypes\AbstractValueType;
use Piggly\ValueTypes\Interfaces\Maskable;
use Respect\Validation\Validator as v;

/**
 * Represents an email address.
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
class EmailType extends AbstractValueType implements Maskable
{
	/**
	 * Constructor.
	 *
	 * @param string|null $email
	 * @param mixed $default Default when $value is null.
	 * @param mixed $required If value is required.
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct ( ?string $email, $default = null, bool $required = false )
	{ 
		$value = \is_null($email) ? $email : \strtolower($email);
		parent::__construct($value, $default, $required);

		$this->apply(v::email());
	}

	/**
	 * Get the masked value to e-mail.
	 * E-mails will be masked as:
	 * \w{3}*{1,}@\w{1}*{1,}.com[n]
	 *
	 * @since 1.0.0
	 * @return string|null
	 */
	public function masked () : ?string
	{
		$email = $this->get();

		if ( \is_null($email) || \strlen($email) <= 3 )
		{ return $email; }

		if ( \strpos($email, '@') === false )
		{ return \str_replace(\substr($email, 3), \str_repeat('*', \strlen($email)-3), $email); }

		list( $before, $after ) = \explode('@', $email);

		$before = \str_replace(\substr($email, 3), \str_repeat('*', \strlen($email)-3), $email);
		$after  = \str_replace(\substr($email, 1), \str_repeat('*', \strpos($after, '.')), $email);

		return $before.'@'.$after;
	}
}