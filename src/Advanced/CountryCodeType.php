<?php
namespace Piggly\ValueTypes\Advanced;

use Piggly\ValueTypes\AbstractValueType;
use Respect\Validation\Rules\CountryCode;
use Respect\Validation\Validator as v;

/**
 * Represents a country code following
 * ISO 3166-1 standard.
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
class CountryCodeType extends AbstractValueType
{
	/**
	 * Constructor.
	 *
	 * @see Respect\Validation\Rules\CountryCode
	 * @param string|null $countryCode
	 * @param string $iso Any of: alpha-2, alpha-3 or numeric.
	 * @param mixed $default Default when $value is null.
	 * @param mixed $required If value is required.
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct ( ?string $countryCode, string $iso = CountryCode::ALPHA2, $default = null, bool $required = false )
	{ 
		$value = \is_null($countryCode) ? $countryCode : \strtoupper($countryCode);
		parent::__construct($value, $default, $required);

		$this->apply(v::countryCode($iso));
	}
}