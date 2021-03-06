<?php
namespace Piggly\ValueTypes\Advanced;

use Piggly\ValueTypes\AbstractMaskedType;
use Respect\Validation\Validator as v;

/**
 * Represents a credit card number.
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
class CreditCardType extends AbstractMaskedType
{
	/**
	 * Constructor.
	 *
	 * @param string|null $creditCard
	 * @param mixed $default Default when $value is null.
	 * @param mixed $required If value is required.
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct ( ?string $creditCard, $default = null, bool $required = false )
	{ 
		$value = \is_null($creditCard) ? $creditCard : \preg_replace('/\D/', '', $creditCard);
		parent::__construct($value, $default, $required);

		if ( $this->isMasked() ) return;
		$this->apply(v::creditCard());
	}

	/**
	 * Get the masked value to credit card.
	 * Will mask everything except the last
	 * 4 digits.
	 *
	 *
	 * @param string $input Input value.
	 * @param bool $keepLength Must keep $input length
	 * @since 1.0.0
	 * @return string|null
	 */
	protected function applyMask ( string $input, bool $keepLength = true ) : string
	{
		if ( \strlen($input) <= 4 )
		{ return $input; }

		$len = \strlen($input) - 4;
		$mask = $keepLength ? \str_repeat('*', $len) : '*';
		return \str_replace(\substr($input, 0, $len), $mask, $input);
	}
}