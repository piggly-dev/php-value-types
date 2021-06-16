<?php
namespace Piggly\ValueTypes\Common;

use Piggly\ValueTypes\AbstractValueType;
use Piggly\ValueTypes\Exceptions\InvalidValueTypeOfException;

class ArrayType extends AbstractValueType
{
	/**
	 * Constructor.
	 *
	 * @param mixed $value
	 * @param mixed $default Default when $value is null.
	 * @param mixed $required If value is required.
	 * @param 
	 * @since 1.0.0
	 * @return void
	 * @throws InvalidValueTypeOfException when JSON is invalid.
	 */
	public function __construct ( $value, $default = null, bool $required = false )
	{ 
		$value = \is_null($value) ? $value : $this->parseValue($value);

		if ( !\is_null($default) && !\is_array($value) )
		{ throw new InvalidValueTypeOfException($this, 'invalid array'); }

		$default = \is_null($default) ? $default : $this->parseValue($default);

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
	private function parseValue ( $value )
	{
		if ( \is_array($value) )
		{ return $value; }

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