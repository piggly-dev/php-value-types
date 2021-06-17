<?php
namespace Piggly\ValueTypes\Advanced;

use DateTime;
use DateTimeImmutable;
use Piggly\ValueTypes\AbstractValueType;
use Piggly\ValueTypes\Exceptions\InvalidValueTypeOfException;

/**
 * Represents an unixtimestamp.
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
class UnixTimestampType extends AbstractValueType
{
	/**
	 * Constructor.
	 * 
	 * If $timestamp is a DateTime object it will 
	 * convert it to timestamp with getTimestamp().
	 *
	 * @param DateTime|integer|null $timestamp
	 * @param mixed $default Default when $value is null.
	 * @param mixed $required If value is required.
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct ( $timestamp, $default = null, bool $required = false )
	{ 
		if ( $timestamp instanceof DateTime )
		{ $timestamp = $timestamp->getTimestamp(); }
		else if ( !\is_null($timestamp) )
		{ $timestamp = \intval($timestamp); }

		parent::__construct($timestamp, $default, $required);
	}

	/**
	 * Convert current timestamp to a 
	 * DateTimeImmutable object.
	 * 
	 * It will assert before convert.
	 *
	 * @since 1.0.0
	 * @return DateTimeImmutable
	 * @throws InvalidValueTypeOfException if timestamp is invalid.
	 */
	public function asDateTime () : DateTimeImmutable
	{ 
		$this->assert();
		return new DateTimeImmutable('@'.\strval($this->_value)); 
	}
}