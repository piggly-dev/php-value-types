<?php
namespace Piggly\ValueTypes\Common;

use Piggly\ValueTypes\AbstractValueType;

/**
 * Represents an integer type. It will always parse
 * $value to a valid integer.
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
class IntegerType extends AbstractValueType
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
	 * Convert $value to int.
	 *
	 * @param mixed $value
	 * @since 1.0.0
	 * @return int
	 */
	private function parse ( $value ) : int
	{
		if ( \is_numeric($value) )
		{ return \intval($value); }

		if ( \is_string($value) )
		{
			if ( $value === 'true' )
			{ return 1; }

			if ( $value === 'false' )
			{ return 0; }

			$value = \preg_replace('/[^\d\.\-]/i', '', $value);
			return \intval($value);
		}

		if ( \is_bool($value) )
		{ return $value ? 1 : 0; }

		if ( \is_array($value) )
		{ return !empty($value) ? 1 : 0; }

		if ( \is_object($value) )
		{ return 0; }

		return \intval($value);
	} 
}