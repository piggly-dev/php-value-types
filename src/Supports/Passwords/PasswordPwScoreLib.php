<?php
namespace Piggly\ValueTypes\Supports\Passwords;

use Piggly\ValueTypes\Supports\Passwords\Interfaces\PasswordStrengthLib;

/**
 * Uses the pwscore to get password strength.
 * 
 * You must install libpwquality-tools to get
 * pwscore command. And you may need to install 
 * dictionaries to improve accuracy.
 * 
 * pwscore will return a numeric value between
 * 0 and 100 or a message if password does not
 * meet the requirements.
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
class PasswordPwScoreLib implements PasswordStrengthLib
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
	 * pwscore to improve this library power.
	 *
	 * @param string $path Path to pwscore.
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct ( string $path = '/usr/bin/pwscore' )
	{ $this->_path = $path; }

	/**
	 * Check password with pwscore library.
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

		if ( ($res == 0) && \is_numeric($out[1]) )
		{ return \intval($out[1]); }
		
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