<?php
namespace Piggly\ValueTypes\Advanced;

use Piggly\ValueTypes\AbstractValueType;
use Respect\Validation\Validator as v;

/**
 * Represents a CNPJ.
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
class CnpjType extends AbstractValueType
{
	/**
	 * Constructor.
	 *
	 * @param string|null $cnpj
	 * @param mixed $default Default when $value is null.
	 * @param mixed $required If value is required.
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct ( ?string $cnpj, $default = null, bool $required = false )
	{ 
		$value = \is_null($cnpj) ? $cnpj : \preg_replace('/^\d/', '', $cnpj);
		parent::__construct($value, $default, $required);

		$this->apply(v::cnpj());
	}

	/**
	 * Get the masked value to CNPJ.
	 * CNPJ will be masked as:
	 * \d{5}*{7}\d{2}
	 *
	 * @since 1.0.0
	 * @return string|null
	 */
	public function masked () : ?string
	{
		$cnpj = $this->get();
		
		if ( \is_null($cnpj) || \strlen($cnpj) !== 14 )
		{ return $cnpj; }
		
		return \str_replace(\substr($cnpj, 5, 7), \str_repeat('*', 7), $cnpj);
	}
}