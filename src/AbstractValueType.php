<?php
namespace Piggly\ValueTypes;

use Exception;
use Piggly\ValueTypes\Exceptions\InvalidValueTypeOfException;

/**
 * Abstract value type which controls:
 * value, default value and required
 * condition.
 *
 * @package \Piggly\ValueTypes
 * @subpackage \Piggly\ValueTypes
 * @version 1.0.0
 * @since 1.0.0
 * @category Values
 * @author Caique Araujo <caique@piggly.com.br>
 * @author Piggly Lab <dev@piggly.com.br>
 * @license MIT
 * @copyright 2021 Piggly Lab <dev@piggly.com.br>
 */
abstract class AbstractValueType
{
	/**
	 * Raw value.
	 *
	 * @var mixed
	 * @since 1.0.0
	 */
	protected $_value;

	/**
	 * Default value when
	 * value is empty.
	 *
	 * @var mixed
	 * @since 1.0.0
	 */
	protected $_default = null;

	/**
	 * Value is required or
	 * not.
	 *
	 * @var boolean
	 * @since 1.0.0
	 */
	protected $_required = false;

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
		$this->_value = $value; 
		$this->_default = $default;
		$this->_required = $required;
	}

	/**
	 * Return if current value is required.
	 *
	 * @since 1.0.0
	 * @return boolean
	 */
	final public function isRequired () : bool
	{ return $this->_required; }

	/**
	 * Return if current value is filled.
	 *
	 * @since 1.0.0
	 * @return boolean
	 */
	final public function isFilled () : bool
	{ return !\is_null($this->_value); }

	/**
	 * Get raw value of ValueType.
	 *
	 * @since 1.0.0
	 * @return mixed
	 */
	final public function getRaw ()
	{ return $this->_value; }

	/**
	 * Get value of ValueType. When value
	 * is not set or null, return the
	 * default value.
	 *
	 * @since 1.0.0
	 * @return mixed
	 */
	final public function get ()
	{ return isset($this->_value) || !\is_null($this->_value) ? $this->_value : $this->_default; }

	/**
	 * Validate value to ValueType.
	 *
	 * @return boolean
	 * @since 1.0.0
	 */
	final public function validate () : bool
	{
		try 
		{ $this->assert(); }
		catch ( Exception $e )
		{ return false; }

		return true;
	}

	/**
	 * Caught error message while trying to
	 * assert value to ValueType.
	 *
	 * @return mixed TRUE when assert, STRING with error message.
	 * @since 1.0.0
	 */
	final public function caught ()
	{
		try 
		{ $this->assert(); }
		catch ( InvalidValueTypeOfException $e )
		{ return $e->getMessage(); }

		return true;
	}

	/**
	 * Assert if value meets the requirements
	 * to ValueType. It must throw an
	 * InvalidValueTypeOfException.
	 *
	 * @since 1.0.0
	 * @return void
	 * @throws InvalidValueTypeOfException
	 */
	public function assert ()
	{
		if ( \is_null($this->get()) && $this->isRequired() )
		{ throw new InvalidValueTypeOfException($this, 'is required'); }
	}
}