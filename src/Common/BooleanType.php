<?php
namespace Piggly\ValueTypes\Common;

use Piggly\ValueTypes\AbstractValueType;

/**
 * Represents a boolean type. It will always parse
 * $value to a valid boolean.
 *
 * @package \Piggly\ValueTypes
 * @subpackage \Piggly\ValueTypes\Common
 * @version 1.0.0
 * @since 1.0.0
 * @category Values
 * @author Caique Araujo <caique@piggly.com.br>
 * @author Piggly Lab <dev@piggly.com.br>
 * @license MIT
 * @copyright 2021 Piggly Lab <dev@piggly.com.br>
 */
class BooleanType extends AbstractValueType
{
	/**
	 * Constructor.
	 *
	 * @param mixed $value
	 * @param mixed $default Default when $value is null.
	 * @param mixed $required If value is required.
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct ( $value, $default = null, bool $required = false )
	{ 
		$value = \is_null($value) ? $value : $this->parse($value);
		$default = \is_null($default) ? $default : $this->parse($default);

		parent::__construct($value, $default, $required);
	}

	/**
	 * Convert $value to boolean.
	 *
	 * @param mixed $value
	 * @since 1.0.0
	 * @return bool
	 */
	private function parse ( $value ) : bool
	{
		if ( $value === 'true' || $value === 'false' )
		{ return $value === 'true' ? true : false; }

		return \boolval($value);
	} 
}