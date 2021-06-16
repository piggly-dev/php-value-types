<?php
namespace Piggly\ValueTypes\Common;

use Piggly\ValueTypes\AbstractValueType;

class StringType extends AbstractValueType
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
	 */
	public function __construct ( $value, $default = null, bool $required = false )
	{ 
		$value = \is_null($value) ? $value : $this->parseValue($value);
		$default = \is_null($default) ? $default : $this->parseValue($default);

		parent::__construct($value, $default, $required);
	}

	/**
	 * Convert $value to string.
	 *
	 * @param mixed $value
	 * @since 1.0.0
	 * @return string
	 */
	private function parseValue ( $value ) : string
	{
		if ( \is_object($value) )
		{
			if ( \method_exists($value, '__toString') )
			{ return $value->__toString(); }

			return \get_class($value);
		}

		if ( \is_array($value) )
		{ return \json_encode($value); }

		return \strval($value);
	} 
}