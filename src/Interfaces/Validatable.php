<?php
namespace Piggly\ValueTypes\Interfaces;

use Exception;

/**
 * Implements the assert() and validate()
 * method to any object. Both need to caught
 * a $input and determine if this $input
 * meets the requirements or not.
 * 
 * To assertions it must always thrown an
 * exception, while to validations it must
 * always return a boolean.
 * 
 * @package \Piggly\ValueTypes
 * @subpackage \Piggly\ValueTypes\Interfaces
 * @version 1.0.0
 * @since 1.0.0
 * @category Interfaces
 * @author Caique Araujo <caique@piggly.com.br>
 * @author Piggly Lab <dev@piggly.com.br>
 * @license MIT
 * @copyright 2021 Piggly Lab <dev@piggly.com.br>
 */
interface Validatable
{
	/**
	 * Assert if $input meets the requirements.
	 * It must throw an Exception.
	 *
	 * @param mixed $input To assert.
	 * @since 1.0.0
	 * @return void
	 * @throws Exception
	 */
	public function assert ( $input );

	/**
	 * Validate if $input meets the requirements.
	 * It must return a boolean.
	 *
	 * @param mixed $input To validate.
	 * @since 1.0.0
	 * @return boolean
	 * @throws Exception
	 */
	public function validate ( $input ) : bool;
}