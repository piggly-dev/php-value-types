<?php
namespace Piggly\ValueTypes\Common;

use Piggly\ValueTypes\AbstractValueType;
use Piggly\ValueTypes\Exceptions\InvalidValueTypeOfException;

class JsonType extends AbstractValueType
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

		if ( json_last_error() !== JSON_ERROR_NONE )
		{ throw new InvalidValueTypeOfException($this, 'JSON is invalid'); }

		$default = \is_null($default) ? $default : $this->parseValue($default);

		if ( json_last_error() !== JSON_ERROR_NONE )
		{ throw new InvalidValueTypeOfException($this, 'JSON is invalid to default value'); }

		parent::__construct($value, $default, $required);
	}

	/**
	 * Convert $value to JSON string.
	 *
	 * @param mixed $value
	 * @since 1.0.0
	 * @return string|boolean
	 */
	private function parseValue ( $value )
	{
		if ( \is_object($value) )
		{
			if ( \method_exists($value, 'toArray') )
			{ return \json_encode($value->toArray()); }

			if ( \method_exists($value, 'toJson') )
			{ return $value->toJson(); }

			if ( \method_exists($value, 'jsonSerialize') )
			{ return \json_encode($value); }

			return \json_encode(\get_class($value));
		}

		if ( $this->isJson($value) )
		{ return $value; }

		return \json_encode($value);
	} 

	/**
	 * Fastest way to checking if $value is a valid
	 * JSON string.
	 * 
	 * @see https://stackoverflow.com/questions/6041741/fastest-way-to-check-if-a-string-is-json-in-php
	 * @param mixed $value
	 * @since 1.0.0
	 * @return boolean
	 */
	public static function isJson ( $value ) : bool
	{
		// A non-string value can never be a JSON string.
		if ( !\is_string( $value ) ) { return false; }

		// Numeric strings are always valid JSON.
		if ( \is_numeric( $value ) ) { return true; }

		// Any non-numeric JSON string must be longer than 2 characters.
		if ( \strlen( $value ) < 2 ) { return false; }

		// "null" is valid JSON string.
		if ( 'null' === $value ) { return true; }

		// "true" and "false" are valid JSON strings.
		if ( 'true' === $value ) { return true; }
		if ( 'false' === $value ) { return false; }

		// Any other JSON string has to be wrapped in {}, [] or "".
		if ( '{' != $value[0] && '[' != $value[0] && '"' != $value[0] )
		{ return false; }

		// Note the last param (1), this limits the depth to the first level.
		$json_data = \json_decode( $value, null, 1 );

		// When json_decode fails, it returns NULL.
		if ( \is_null( $json_data ) ) { return false; }
		
		return true;
	}
}