<?php
namespace Piggly\ValueTypes\Advanced;

use Piggly\ValueTypes\AbstractValueType;

/**
 * Represents a string with digits.
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
class DigitsType extends AbstractValueType
{
	/**
	 * Constructor.
	 *
	 * @param string|integer|null $digits
	 * @param mixed $default Default when $value is null.
	 * @param mixed $required If value is required.
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct ( $digits, $default = null, bool $required = false )
	{ 
		$value = \is_null($digits) ? $digits : \preg_replace('/\D/', '', \strval($digits));
		parent::__construct($value, $default, $required);
	}
}