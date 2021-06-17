<?php
namespace Piggly\ValueTypes\Advanced;

use Piggly\ValueTypes\AbstractValueType;
use Respect\Validation\Validator as v;

/**
 * Represents a currency code following
 * ISO 4217 standard.
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
class CurrencyCodeType extends AbstractValueType
{
	/**
	 * Constructor.
	 *
	 * @param string|null $currencyCode
	 * @param mixed $default Default when $value is null.
	 * @param mixed $required If value is required.
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct ( ?string $currencyCode, $default = null, bool $required = false )
	{ 
		$value = \is_null($currencyCode) ? $currencyCode : \strtoupper($currencyCode);
		parent::__construct($value, $default, $required);

		$this->apply(v::currencyCode());
	}
}