<?php
namespace Piggly\ValueTypes\Advanced;

use Piggly\ValueTypes\AbstractMaskedType;
use Respect\Validation\Validator as v;

/**
 * Represents a phone.
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
class PhoneType extends AbstractMaskedType
{
	/**
	 * Constructor.
	 *
	 * @param string|null $phone
	 * @param mixed $default Default when $value is null.
	 * @param mixed $required If value is required.
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct ( ?string $phone, $default = null, bool $required = false )
	{ 
		parent::__construct($phone, $default, $required);

		if ( $this->isMasked() ) return;
		$this->apply(v::phone());
	}

	/**
	 * Get the masked value to phone.
	 * Mask all except the last 3 digits.
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
		
		$input = \preg_replace('/\D/', '', $input);
		$len = \strlen($input) - 3;
		$mask = $keepLength ? \str_repeat('*', $len) : '*';
		return \str_replace(\substr($input, 0, $len), $mask, $input);
	}
}