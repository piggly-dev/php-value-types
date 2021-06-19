<?php
namespace Piggly\ValueTypes\Common;

use Piggly\ValueTypes\AbstractValueType;

/**
 * Represents a string type. It will always parse
 * $value to a valid string.
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
class StringType extends AbstractValueType
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
	 * Convert $value to string.
	 *
	 * @param mixed $value
	 * @since 1.0.0
	 * @return string
	 */
	private function parse ( $value ) : string
	{
		if ( \is_string($value) )
		{ return $value; }

		if ( \is_bool($value) )
		{ return $value ? 'true' : 'false'; }

		if ( \is_object($value) )
		{
			if ( \method_exists($value, '__toString') )
			{ return \strval($value); }

			return \get_class($value);
		}

		if ( \is_array($value) )
		{ return \json_encode($value); }

		return \strval($value);
	} 
}