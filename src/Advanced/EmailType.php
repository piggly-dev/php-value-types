<?php
namespace Piggly\ValueTypes\Advanced;

use Piggly\ValueTypes\AbstractMaskedType;
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
class EmailType extends AbstractMaskedType
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

		if ( $this->isMasked() ) return;
		$this->apply(v::email());
	}

	/**
	 * Get the masked value to e-mail.
	 * E-mails will be masked as:
	 * \w{3}*{1,}@\w{1}*{1,}.com[n]
	 *
	 * @param string $input Input value.
	 * @param bool $keepLength Must keep $input length
	 * @since 1.0.0
	 * @return string|null
	 */
	protected function applyMask ( string $input, bool $keepLength = true ) : string
	{
		if ( \strlen($input) <= 3 )
		{ return $input; }

		if ( \strpos($input, '@') === false )
		{ return \str_replace(\substr($input, 3), \str_repeat('*', \strlen($input)-3), $input); }

		list( $before, $after ) = \explode('@', $input);

		if ( !$keepLength )
		{
			$before = \str_replace(\substr($before, 3), '*', $before);
			$dotPos = \strpos($after, '.')-1;
			$after = \str_replace(\substr($after, 1, $dotPos), '*', $after);

			return $before.'@'.$after;
		}

		$before = \str_replace(\substr($before, 3), \str_repeat('*', \strlen($before)-3), $before);
		$dotPos = \strpos($after, '.')-1;
		$after  = \str_replace(\substr($after, 1, $dotPos), \str_repeat('*', $dotPos), $after);

		return $before.'@'.$after;
	}
}