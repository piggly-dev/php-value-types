<?php
namespace Piggly\ValueTypes\Advanced;

use Piggly\ValueTypes\AbstractValueType;
use Respect\Validation\Validator as v;

/**
 * Represents a hexadecimal rgb color.
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
class HexRgbColorType extends AbstractValueType
{
	/**
	 * Constructor.
	 *
	 * @param string|null $hexRgbColor
	 * @param mixed $default Default when $value is null.
	 * @param mixed $required If value is required.
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct ( ?string $hexRgbColor, $default = null, bool $required = false )
	{ 
		$value = \is_null($hexRgbColor) ? $hexRgbColor : '#'.trim(\strtoupper($hexRgbColor), '#');
		parent::__construct($value, $default, $required);

		$this->apply(v::hexRgbColor());
	}
}