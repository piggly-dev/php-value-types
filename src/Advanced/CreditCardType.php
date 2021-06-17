<?php
namespace Piggly\ValueTypes\Advanced;

use Piggly\ValueTypes\AbstractValueType;
use Piggly\ValueTypes\Interfaces\Maskable;
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
class CreditCardType extends AbstractValueType implements Maskable
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
		$value = \is_null($creditCard) ? $creditCard : \preg_replace('/^\d/', '', $creditCard);
		parent::__construct($value, $default, $required);

		$this->apply(v::creditCard());
	}

	/**
	 * Get the masked value to credit card.
	 * Will mask everything except the last
	 * 4 digits.
	 *
	 * @since 1.0.0
	 * @return string|null
	 */
	public function masked () : ?string
	{
		$creditCard = $this->get();
		
		if ( \is_null($creditCard) || \strlen($creditCard) <= 4 )
		{ return $creditCard; }

		$len = \strlen($creditCard) - 4;
		return \str_replace(\substr($creditCard, 0, $len), \str_repeat('*', $len), $creditCard);
	}
}