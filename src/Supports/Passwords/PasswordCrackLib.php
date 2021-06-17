<?php
namespace Piggly\ValueTypes\Supports\Passwords;

use Piggly\ValueTypes\Supports\Passwords\Interfaces\PasswordStrengthLib;

/**
 * Uses the cracklib-check to get password strength.
 * 
 * You must install cracklib to get cracklib-check
 * command. And you may need to install dictionaries
 * to improve accuracy.
 * 
 * cracklib-check will return OK if password is valid
 * or a message if password does not meet the
 * requirements.
 * 
 * cracklib-check does not compute the password score
 * so it will return the minimum of 75.
 * 
 * To add dict to library:
 * 
 * First, you will need a txt file with one
 * word per line, then you must run 
 * create-cracklib-dict /path/to/dict
 * 
 * @package \Piggly\ValueTypes
 * @subpackage \Piggly\ValueTypes\Supports\Passwords
 * @version 1.0.0
 * @since 1.0.0
 * @category Passwords
 * @author Caique Araujo <caique@piggly.com.br>
 * @author Piggly Lab <dev@piggly.com.br>
 * @license MIT
 * @copyright 2021 Piggly Lab <dev@piggly.com.br>
 */
class PasswordCrackLib implements PasswordStrengthLib
{
	/**
	 * Path to command.
	 *
	 * @var string
	 * @since 1.0.0
	 */
	protected $_path;

	/**
	 * Command output message.
	 *
	 * @var string
	 * @since 1.0.0
	 */
	protected $_message = null;

	/**
	 * Constructor.
	 * 
	 * You may need to install dictionaries to 
	 * cracklib to improve this library power.
	 *
	 * @see https://www.linuxfromscratch.org/blfs/view/svn/postlfs/cracklib.html
	 * @param string $path Path to cracklib-check.
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct ( string $path = '/usr/sbin/cracklib-check' )
	{ $this->_path = $path; }

	/**
	 * Check password with cracklib-check library.
	 * 
	 * The checklib-check will not return any score
	 * so, by default, if pass the requirement, score
	 * will be 75.
	 *
	 * @see https://www.the-art-of-web.com/php/password-strength/
	 * @param string $raw
	 * @since 1.0.0
	 * @return int|bool
	 */
	public function strength ( $raw )
	{
		$raw = \escapeshellarg($raw);
		$command = "echo {$raw} | {$this->_path}";
		
		\exec($command, $out, $res);

		if ( ($res == 0) && \preg_match("/: ([^:]+)$/", $out[0], $regs) )
		{
			list(, $msg) = $regs;

			if ( $msg === 'OK' )
			{ return 75; }

			$this->_message = $msg;
		}

		return false;
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
	{ return $this->_message; }
}