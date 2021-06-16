<?php
namespace Piggly\ValueTypes\Exceptions;

use Piggly\ValueTypes\AbstractValueType;
use RuntimeException;

/**
 * Throw an invalid value type exception. It
 * will parse a message with current value,
 * value type name and hint message.
 *
 * @package \Piggly\ValueTypes
 * @subpackage \Piggly\ValueTypes\Exceptions
 * @version 1.0.0
 * @since 1.0.0
 * @category Exceptions
 * @author Caique Araujo <caique@piggly.com.br>
 * @author Piggly Lab <dev@piggly.com.br>
 * @license MIT
 * @copyright 2021 Piggly Lab <dev@piggly.com.br>
 */
class InvalidValueTypeOfException extends RuntimeException
{
	/**
	 * Throw an invalid value type exception. It
	 * will parse a message with current value,
	 * value type name and hint message.
	 *
	 * @param AbstractValueType $valueType
	 * @param string $message By default 'unknown value'
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct ( AbstractValueType $valueType, string $message = null )
	{
		$message = \is_null($message) ? 'unknown value' : $message;
		$value = $this->parseValue($valueType);

		$this->message = \sprintf(
			'Unexpected value %s to %s: %s.', 
			$value,
			get_class($valueType),
			$message
		);
	}

	/**
	 * Convert $valueType to string.
	 *
	 * @param AbstractValueType $valueType
	 * @since 1.0.0
	 * @return string
	 */
	private function parseValue ( AbstractValueType $valueType ) : string
	{
		$value = $valueType->getRaw();

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
