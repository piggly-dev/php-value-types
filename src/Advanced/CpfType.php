<?php
namespace Piggly\ValueTypes\Advanced;

use Piggly\ValueTypes\AbstractValueType;
use Piggly\ValueTypes\Interfaces\Maskable;
use Respect\Validation\Validator as v;

/**
 * Represents a CPF.
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
class CpfType extends AbstractValueType implements Maskable
{
	/**
	 * Constructor.
	 *
	 * @param string|null $cpf
	 * @param mixed $default Default when $value is null.
	 * @param mixed $required If value is required.
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct ( ?string $cpf, $default = null, bool $required = false )
	{ 
		$value = \is_null($cpf) ? $cpf : \preg_replace('/^\d/', '', $cpf);
		parent::__construct($value, $default, $required);

		$this->apply(v::cpf());
	}

	/**
	 * Get the masked value to CPF.
	 * CPF will be masked as:
	 * \d{4}*{5}\d{2}
	 *
	 * @since 1.0.0
	 * @return string|null
	 */
	public function masked () : ?string
	{
		$cpf = $this->get();
		
		if ( \is_null($cpf) || \strlen($cpf) !== 11 )
		{ return $cpf; }

		return \str_replace(\substr($cpf, 4, 5), \str_repeat('*', 5), $cpf);
	}
}