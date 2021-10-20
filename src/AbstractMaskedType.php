<?php
namespace Piggly\ValueTypes;

/**
 * Abstract mask type indicates the value
 * is masked by some function.
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
abstract class AbstractMaskedType extends AbstractValueType
{
	/**
	 * Masked value.
	 *
	 * @var boolean
	 */
	protected $_masked = false;

	/**
	 * Constructor.
	 *
	 * @param string|null $value
	 * @param mixed $default Default when $value is null.
	 * @param mixed $required If value is required.
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct ( ?string $value, $default = null, bool $required = false )
	{ 
		$this->_masked = \is_null($value) ? false : \strpos($value, '*') !== false;
		parent::__construct($value, $default, $required);
	}

	/**
	 * Return if is masked.
	 *
	 * @since 1.0.0
	 * @return boolean
	 */
	final public function isMasked () : bool
	{ return $this->_masked; }

	/**
	 * Get value masked.
	 *
	 * @param boolean $keepLength
	 * @since 1.0.0
	 * @return string|null
	 */
	final public function masked ( bool $keepLength = true ) : ?string
	{
		if ( $this->isMasked() )
		{ return $this->_value; }

		if ( $this->isNull() )
		{ return null; }

		return $this->applyMask($this->_value, $keepLength);
	}

	/**
	 * Get the masked value of $input.
	 *
	 * @param string $input Input value.
	 * @param bool $keepLength Must keep $input length
	 * @since 1.0.0
	 * @return string|null
	 */
	abstract protected function applyMask ( string $input, bool $keepLength = true ) : string;
}