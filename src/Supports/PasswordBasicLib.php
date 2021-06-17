<?php
namespace Piggly\ValueTypes\Supports;

use Piggly\ValueTypes\Interfaces\PasswordStrengthLib;
use ZxcvbnPhp\Zxcvbn;

/**
 * Detect characters at password to determine
 * the password score. It will use zxcvbn algorithm.
 * 
 * It should be used with another lib for better
 * accuracy.
 * 
 * @package \Piggly\ValueTypes
 * @subpackage \Piggly\ValueTypes\Supports
 * @version 1.0.0
 * @since 1.0.0
 * @category Values
 * @author Caique Araujo <caique@piggly.com.br>
 * @author Piggly Lab <dev@piggly.com.br>
 * @license MIT
 * @copyright 2021 Piggly Lab <dev@piggly.com.br>
 */
class PasswordBasicLib implements PasswordStrengthLib
{
	/**
	 * Do a basic password requirement, by running
	 * zxcvbn algorithm and basic requiments.
	 * 
	 * It should be used with another lib for better
	 * accuracy.
	 * 
	 * @param string $raw
	 * @since 1.0.0
	 * @return int|bool
	 */
	public function strength ( $raw )
	{
		$bypass = (new Zxcvbn())->passwordStrength($raw);
		$score  = $bypass['score'] * 25;

		// Will decrease score based in user choices
		// to meet basic requirements

		if ( !preg_match('@[A-Z]@', $raw) )
		{ $score -= 5; }

		if ( !preg_match('@[a-z]@', $raw) )
		{ $score -= 5; }

		if ( !preg_match('@[0-9]@', $raw) )
		{ $score -= 5; }

		if ( !preg_match('@[^\w]@', $raw) )
		{ $score -= 5; }

		if ( strlen($raw) < 8 )
		{ $score -= 5; }

		return $score;
	}

	/**
	 * May return a support message when
	 * password does not meet requirements
	 * after executing strength() method.
	 *
	 * @since 1.0.0
	 * @return string|null
	 */
	public function getMessage () : ?string
	{ return null; }
}