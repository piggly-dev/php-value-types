<?php
namespace Piggly\ValueTypes\Common;

use Piggly\ValueTypes\AbstractValueType;
use Piggly\ValueTypes\Exceptions\InvalidValueTypeOfException;

/**
 * Represents an array type. It will always parse
 * $value to a valid array.
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
class ArrayType extends AbstractValueType
{
	/**
	 * Constructor.
	 *
	 * @param mixed $value
	 * @param mixed $default Default when $value is null.
	 * @param mixed $required If value is required.
	 * @since 1.0.0
	 * @return void
	 * @throws InvalidValueTypeOfException when JSON is invalid.
	 */
	public function __construct ( $value, $default = null, bool $required = false )
	{ 
		$value = \is_null($value) ? $value : $this->parse($value);

		if ( !\is_null($value) && !\is_array($value) )
		{ throw new InvalidValueTypeOfException($this, 'invalid array'); }

		$default = \is_null($default) ? $default : $this->parse($default);

		if ( !\is_null($default) && !\is_array($default) )
		{ throw new InvalidValueTypeOfException($this, 'invalid array'); }

		parent::__construct($value, $default, $required);
	}

	/**
	 * Convert $value to array.
	 *
	 * @param mixed $value
	 * @since 1.0.0
	 * @return mixed
	 */
	private function parse ( $value )
	{
		if ( \is_array($value) )
		{ return $value; }

		if ( empty($value) )
		{ return []; }

		if ( \is_object($value) )
		{
			if ( \method_exists($value, 'toArray') )
			{ return $value->toArray(); }

			if ( \method_exists($value, 'toJson') )
			{ return \json_decode($value->toJson(), true); }

			if ( \method_exists($value, 'jsonSerialize') )
			{ return \json_decode(\json_encode($value), true); }

			return false;
		}

		return \json_decode($value, true);
	} 
}