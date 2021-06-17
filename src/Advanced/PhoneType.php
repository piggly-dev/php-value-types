<?php
namespace Piggly\ValueTypes\Advanced;

use Piggly\ValueTypes\AbstractValueType;
use Piggly\ValueTypes\Interfaces\Maskable;
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
class PhoneType extends AbstractValueType implements Maskable
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

		$this->apply(v::phone());
	}

	/**
	 * Get the masked value to phone.
	 * Mask all except the last 3 digits.
	 *
	 * @since 1.0.0
	 * @return string|null
	 */
	public function masked () : ?string
	{
		$phone = $this->get();

		if ( \is_null($phone) || \strlen($phone) <= 3 )
		{ return $phone; }
		
		$phone = \preg_replace('/^\d/', '', $phone);
		$len = \strlen($phone) - 3;
		return \str_replace(\substr($phone, 0, $len), \str_repeat('*', $len), $phone);
	}
}