<?php
namespace Piggly\ValueTypes\Advanced;

use Piggly\ValueTypes\AbstractMaskedType;
use Respect\Validation\Validator as v;

/**
 * Represents a CNH.
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
class CnhType extends AbstractMaskedType
{
	/**
	 * Constructor.
	 *
	 * @param string|null $cnh
	 * @param mixed $default Default when $value is null.
	 * @param mixed $required If value is required.
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct ( ?string $cnh, $default = null, bool $required = false )
	{ 
		$value = \is_null($cnh) ? $cnh : \preg_replace('/\D/', '', $cnh);
		parent::__construct($value, $default, $required);

		if ( $this->isMasked() ) return;
		$this->apply(v::cnh());
	}

	/**
	 * Get the masked value to CNH.
	 * CNH will be masked as:
	 * \d{4}*{5}\d{2}
	 *
	 * @param string $input Input value.
	 * @param bool $keepLength Must keep $input length
	 * @since 1.0.0
	 * @return string|null
	 */
	protected function applyMask ( string $input, bool $keepLength = true ) : string
	{
		if ( \strlen($input) !== 11 )
		{ return $input; }

		$mask = $keepLength ? \str_repeat('*', 6) : '*';
		return \str_replace(\substr($input, 4, 6), $mask, $input);
	}
}