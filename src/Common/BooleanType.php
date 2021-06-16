<?php
namespace Piggly\ValueTypes\Common;

use Piggly\ValueTypes\AbstractValueType;

class BooleanType extends AbstractValueType
{
	/**
	 * Constructor.
	 *
	 * @param mixed $value
	 * @param mixed $default Default when $value is null.
	 * @param mixed $required If value is required.
	 * @param 
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct ( $value, $default = null, bool $required = false )
	{ 
		$value = \is_null($value) ? $value : \boolval($value);
		$default = \is_null($default) ? $default : \boolval($default);

		parent::__construct($value, $default, $required);
	}
}