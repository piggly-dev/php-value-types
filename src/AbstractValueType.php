<?php
namespace Piggly\ValueTypes;

use Exception;
use Piggly\ValueTypes\Common\StringType;
use Piggly\ValueTypes\Exceptions\InvalidValueTypeOfException;
use Piggly\ValueTypes\Interfaces\Validatable;
use Respect\Validation\Validatable as RespectValidatable;
use RuntimeException;

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
	 * Value cannot be null.
	 *
	 * @var bool
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
	 * @var array<Validatable|RespectValidatable>
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
	 * Get raw value, ignoring the default
	 * value.
	 *
	 * @since 1.0.0
	 * @return mixed
	 */
	final public function getRaw ()
	{ return $this->_value; }

	/**
	 * Return if current value is not null. 
	 * ! This method does not care if value
	 * pass to assertions.
	 * ! This method ignores the default
	 * value, even it is set.
	 *
	 * @since 1.0.0
	 * @return boolean
	 */
	final public function isRawNotNull () : bool
	{ return !\is_null($this->_value); }

	/**
	 * Return if current value is null.
	 * ! This method does not care if value
	 * pass to assertions.
	 * ! This method ignores the default
	 * value, even it is set.
	 *
	 * @since 1.0.0
	 * @return boolean
	 */
	final public function isRawNull () : bool
	{ return \is_null($this->_value); }

	/**
	 * Get value of ValueType. When value
	 * is null, return the default value
	 * if it exists.
	 * 
	 * @since 1.0.0
	 * @return mixed|null
	 */
	final public function get ()
	{ return $this->_value ?? $this->_default; }

	/**
	 * Return if current value is not null. 
	 * ! This method does not care if value
	 * pass to assertions.
	 *
	 * @since 1.0.0
	 * @return boolean
	 */
	final public function isNotNull () : bool
	{ return !\is_null($this->_value ?? $this->_default); }

	/**
	 * Return if current value is null.
	 * ! This method does not care if value
	 * pass to assertions.
	 *
	 * @since 1.0.0
	 * @return boolean
	 */
	final public function isNull () : bool
	{ return \is_null($this->_value ?? $this->_default); }

	/**
	 * Applyies a validatable rule to this value type.
	 *
	 * @param Validatable|RespectValidatable $rule
	 * @since 1.0.0
	 * @return self
	 * @throws RuntimeException If $rule does not implement interfaces.
	 */
	final public function apply ( $rule )
	{ 
		if ( $rule instanceof Validatable || $rule instanceof RespectValidatable )
		{
			$this->_assertions[] = $rule; 
			$this->_asserted = false;
			return $this; 
		}

		throw new RuntimeException('Rule must implements Validatable or RespectValidatable interface');
	}

	/**
	 * Validate value with assertions.
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
	 * Validate value with assertions, but
	 * if fail return the error message to
	 * assertion.
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
	 * Assert if value meets the requirements. 
	 * It must throw an InvalidValueTypeOfException
	 * if does not assert.
	 * 
	 * By default will always assert if value is required
	 * and if so validate if it is set.
	 * 
	 * It will just run if current value is not
	 * asserted or if was added a new assertion to this
	 * object.
	 *
	 * @since 1.0.0
	 * @return self
	 * @throws InvalidValueTypeOfException
	 */
	final public function assert ()
	{
		if ( $this->_asserted )
		{ return $this; }

		$value = isset($this->_value) || !\is_null($this->_value) ? $this->_value : $this->_default;
		
		if ( \is_null($value) && $this->isRequired() )
		{ throw new InvalidValueTypeOfException($this, 'is required'); }
		
		// Allow null so should not validate 
		if ( \is_null($value) )
		{ 
			$this->_asserted = true;
			return $this; 
		}

		if ( !empty($this->_assertions) )
		{
			foreach ( $this->_assertions as $assertions )
			{
				try
				{ $assertions->assert($value); }
				catch ( Exception $e )
				{ throw new InvalidValueTypeOfException($this, $e->getMessage()); }
			}
		}
			
		// Cache assertion
		$this->_asserted = true;
		return $this;
	}

	/**
	 * Convert current object to string
	 * by using (string) or strval().
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function __toString ()
	{ 
		if ( $this instanceof StringType )
		{ return $this->_value ?? $this->_default ?? 'NULL'; }

		return (new StringType($this->get()))->get() ?? 'NULL'; 
	}
}