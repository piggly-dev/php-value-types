<?php
namespace Piggly\ValueTypes\Advanced;

use Piggly\ValueTypes\AbstractValueType;
use Respect\Validation\Validator as v;

/**
 * Represents a URL slug.
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
class SlugType extends AbstractValueType
{
	/**
	 * Constructor.
	 *
	 * @param string|null $slug
	 * @param mixed $default Default when $value is null.
	 * @param mixed $required If value is required.
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct ( ?string $slug, $default = null, bool $required = false )
	{ 
		parent::__construct($this->parse($slug), $default, $required);
		$this->apply(v::slug());
	}

	/**
	 * Convert $value to slug string.
	 *
	 * @see https://wordpress.stackexchange.com/questions/74415/how-does-wordpress-generate-url-slugs
	 * @param mixed $value
	 * @since 1.0.0
	 * @return string|null
	 */
	private function parse ( $value ) : ?string
	{
		if ( \is_null($value) )
		{ return $value; }

		// replace non letter or digits by -
		$value = \preg_replace('~[^\pL\d]+~u', '-', $value);

		// transliterate
		$value = \iconv('utf-8', 'us-ascii//TRANSLIT', $value);

		// remove unwanted characters
		$value = \preg_replace('~[^-\w]+~', '', $value);

		// trim
		$value = \trim($value, '-');

		// remove duplicate -
		$value = \preg_replace('~-+~', '-', $value);

		// lowercase
		$value = \strtolower($value);

		return $value;
	}
}