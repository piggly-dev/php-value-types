<?php
namespace Piggly\ValueTypes;

use Exception;
use Piggly\ValueTypes\Exceptions\InvalidValueTypeOfException;
use Respect\Validation\Validatable;

/**
 * Abstract value type which controls:
 * value, default value and required
 * condition.
 * 
 * Any ValueType object is a immutable
 * value that can be asserted with a list
 * of rules. By default, any object will
 * be asserted first as required, later
 * with all other assertions.
 * 
 * The assertions are cached at object, so
 * they will be executed only once since
 * object value is immutable. But, if add
 * a new asserting rule, then cache gone.
 * 
 * Value should be changed at __constructor
 * method, after it will not be changed anymore.
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
	 * Cache assertion to value since
	 * value is immutable. But, uncache
	 * if apply new Validatable objects
	 * to assertion.
	 *
	 * @var boolean
	 */
	private $_asserted = false;

	/**
	 * A collection of Validatable
	 * objects to assert.
	 *
	 * @var array<Validatable>
	 * @since 1.0.0
	 */
	private $_assertions = [];

	/**
	 * Constructor.
	 *
	 * @param mixed $value
	 * @param mixed $default Default when $value is null.
	 * @param mixed $required If value is required.
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
	 * Assert value before get it.
	 * 
	 * Call mutates() method if it exists
	 * and value is not mutated.
	 * 
	 * @since 1.0.0
	 * @return mixed
	 * @throws InvalidValueTypeOfException if value is unexpected
	 */
	final public function get ()
	{ 
		$this->assert();
		return isset($this->_value) || !\is_null($this->_value) ? $this->_value : $this->_default; 
	}

	/**
	 * Applyies a validatable rule to this value type.
	 *
	 * @param Validatable $rule
	 * @since 1.0.0
	 * @return self
	 */
	final public function apply ( Validatable $rule )
	{ 
		$this->_assertions[] = $rule; 
		$this->_asserted = false;
		return $this; 
	}

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
	final public function assert ()
	{
		if ( $this->_asserted )
		{ return; }

		if ( \is_null($this->get()) && $this->isRequired() )
		{ throw new InvalidValueTypeOfException($this, 'is required'); }
		
		// Allow null so should not validate 
		if ( \is_null($this->get()) )
		{ return; }

		if ( !empty($this->_assertions) )
		{
			$value = $this->get();

			foreach ( $this->_assertions as $assertions )
			{
				try
				{ $assertions->assert($value); }
				catch ( Exception $e )
				{ throw new InvalidValueTypeOfException($this, $e->getMessage()); }
			}
		}

		$this->_asserted = true;
	}
}