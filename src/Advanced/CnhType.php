<?php
namespace Piggly\ValueTypes\Advanced;

use Piggly\ValueTypes\AbstractValueType;
use Piggly\ValueTypes\Interfaces\Maskable;
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
class CnhType extends AbstractValueType implements Maskable
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
		$value = \is_null($cnh) ? $cnh : \preg_replace('/^\d/', '', $cnh);
		parent::__construct($value, $default, $required);

		$this->apply(v::cnh());
	}

	/**
	 * Get the masked value to CNH.
	 * CNH will be masked as:
	 * \d{4}*{5}\d{2}
	 *
	 * @since 1.0.0
	 * @return string|null
	 */
	public function masked () : ?string
	{
		$cnh = $this->get();
		
		if ( \is_null($cnh) || \strlen($cnh) !== 11 )
		{ return $cnh; }

		return \str_replace(\substr($cnh, 4, 5), \str_repeat('*', 5), $cnh);
	}
}