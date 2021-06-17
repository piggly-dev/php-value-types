<?php
namespace Piggly\ValueTypes\Advanced;

use Piggly\ValueTypes\AbstractValueType;
use Respect\Validation\Validator as v;

/**
 * Represents a IP.
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
class IpType extends AbstractValueType
{
	/**
	 * Constructor.
	 *
	 * @param string|null $ip
	 * @param string $range IP Range such as 220.78.168.0/21
	 * @param integer $options IP Filter as FILTER_FLAG_NO_PRIV_RANGE or FILTER_FLAG_IPV6
	 * @param mixed $default Default when $value is null.
	 * @param mixed $required If value is required.
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct ( ?string $ip, string $range = null, int $options = null, $default = null, bool $required = false )
	{ 
		parent::__construct($ip, $default, $required);

		$this->apply(v::ip($range, $options));
	}
}