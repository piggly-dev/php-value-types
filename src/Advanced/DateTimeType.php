<?php
namespace Piggly\ValueTypes\Advanced;

use DateTime;
use DateTimeImmutable;
use Piggly\ValueTypes\AbstractValueType;
use Piggly\ValueTypes\Exceptions\InvalidValueTypeOfException;
use Respect\Validation\Validator as v;

/**
 * Represents a date time.
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
class DateTimeType extends AbstractValueType
{
	/**
	 * Constructor.
	 * 
	 * If $dateTime is a DateTime object it will 
	 * convert it to a regular string according
	 * to $format (by default Y-m-d H:i:s). Same
	 * if $dateTime is an integer as timestamp.
	 *
	 * @param DateTime|integer|string|null $dateTime
	 * @param string $format Date string format.
	 * @param mixed $default Default when $value is null.
	 * @param mixed $required If value is required.
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct ( $dateTime, string $format = 'Y-m-d H:i:s', $default = null, bool $required = false )
	{ 
		if ( $dateTime instanceof DateTime )
		{ $dateTime = $dateTime->format($format); }
		else if ( \intval($dateTime) )
		{ $dateTime = (new DateTime('@'.\strval($dateTime)))->format($format); }

		parent::__construct($dateTime, $default, $required);

		$this->apply(v::dateTime($format));
	}

	/**
	 * Convert current date to a 
	 * DateTimeImmutable object. 
	 * Time will be always 00:00:00.
	 * 
	 * It will assert before convert.
	 *
	 * @since 1.0.0
	 * @return DateTimeImmutable
	 * @throws InvalidValueTypeOfException if date is invalid.
	 */
	public function asDateTime () : DateTimeImmutable
	{ 
		$this->assert();
		return new DateTimeImmutable($this->_value); 
	}
}