<?php
namespace Piggly\Tests\ValueTypes\Common;

use PHPUnit\Framework\TestCase;
use Piggly\ValueTypes\AbstractValueType;
use Piggly\ValueTypes\Common\ArrayType;
use Piggly\ValueTypes\Common\BooleanType;
use Piggly\ValueTypes\Common\FloatType;
use Piggly\ValueTypes\Common\IntegerType;
use Piggly\ValueTypes\Common\StringType;
use stdClass;

/**
 * @coversDefaultClass \Piggly\ValueTypes\Common\AbstractValueType
 */
class CastToStringTest extends TestCase
{
	/**
	 * Assert if $value to string is $expected.
	 *
	 * @covers ::__toString
	 * @dataProvider dataValues
	 * @test Expecting positive assertion.
	 * @param string $expected Expected result.
	 * @param AbstractValueType $obj Value to parse
	 * @return boolean
	 */
	public function canParse ( string $expected, AbstractValueType $obj )
	{ $this->assertEquals($expected, \strval($obj)); }

	/**
	 * A list with random values to validate.
	 * Provider to canParse() method.
	 * @return array
	 */
	public function dataValues () : array
	{
		return [
			['[]', new ArrayType(0)],
			['[]', new ArrayType('0')],
			['[]', new ArrayType('')],
			['[]', new ArrayType([])],
			['[1,2,3]', new ArrayType([1,2,3])],
			['[{"key":"value"}]', new ArrayType([['key'=>'value']])],
			['[1,2,3]', new ArrayType('[1,2,3]')],
			['[{"key":"value"}]', new ArrayType('[{"key":"value"}]')],

			['true', new BooleanType(true)],
			['true', new BooleanType('true')],
			['true', new BooleanType('1')],
			['true', new BooleanType('string')],
			['true', new BooleanType([1,2,3])],
			['true', new BooleanType(1)],
			['true', new BooleanType(1.5)],
			['true', new BooleanType(2)],
			['true', new BooleanType(2.5)],
			['true', new BooleanType(new stdClass())],
			['false', new BooleanType(false)],
			['false', new BooleanType('false')],
			['false', new BooleanType('0')],
			['false', new BooleanType('')],
			['false', new BooleanType([])],
			['false', new BooleanType(0)],
			['false', new BooleanType(0.0)],
			
			['1', new FloatType('1')],
			['2.5', new FloatType('2.5')],
			['200000', new FloatType('2.e5')],
			['1', new FloatType(1)],
			['2.5', new FloatType(2.5)],
			['-1', new FloatType('-1')],
			['-2.5', new FloatType('-2.5')],
			['-200000', new FloatType('-2.e5')],
			['-1', new FloatType(-1)],
			['-2.5', new FloatType(-2.5)],
			['1', new FloatType('true')],
			['0', new FloatType('false')],
			['1500.99', new FloatType('1,500.99')],
			['1500.99', new FloatType('$ 1,500.99')],
			['-1500.99', new FloatType('-1,500.99')],
			['-1500.99', new FloatType('$ -1,500.99')],
			['0', new FloatType('string')],
			['1', new FloatType(true)],
			['0', new FloatType(false)],
			['1', new FloatType([1,2,3])],
			['0', new FloatType([])],
			['0', new FloatType(new stdClass())],
			
			['42', new IntegerType(42)],
			['4', new IntegerType(4.2)],
			['42', new IntegerType('42')],
			['42', new IntegerType('+42')],
			['-42', new IntegerType('-42')],
			['-42', new IntegerType(-42)],
			['34', new IntegerType(042)],
			['10000000000', new IntegerType(1e10)], // 64-bit
			['10000000000', new IntegerType('1e10')], // 64-bit
			['26', new IntegerType(0x1A)],
			['42000000', new IntegerType(42000000)],
			['-4275113695319687168', new IntegerType(420000000000000000000)], // 64-bit
			['9223372036854775807', new IntegerType('420000000000000000000')], // 64-bit
			['1', new IntegerType('true')],
			['0', new IntegerType('false')],
			['1500', new IntegerType('1,500.99')],
			['1500', new IntegerType('$ 1,500.99')],
			['-1500', new IntegerType('-1,500.99')],
			['-1500', new IntegerType('$ -1,500.99')],
			['0', new IntegerType('string')],
			['1', new IntegerType(true)],
			['0', new IntegerType(false)],
			['1', new IntegerType([1,2,3])],
			['0', new IntegerType([])],
			['0', new IntegerType(new stdClass())],

			['true', new StringType(true)],
			['true', new StringType('true')],
			['1', new StringType('1')],
			['string', new StringType('string')],
			['[1,2,3]', new StringType([1,2,3])],
			['[{"key":"value"}]', new StringType([['key'=>'value']])],
			['1', new StringType(1)],
			['1.5', new StringType(1.5)],
			['2', new StringType(2)],
			['2.5', new StringType(2.5)],
			['stdClass', new StringType(new stdClass())],
			['false', new StringType(false)],
			['false', new StringType('false')],
			['0', new StringType('0')],
			['0.0', new StringType('0.0')],
			['', new StringType('')],
			['[]', new StringType([])],

			['NULL', new ArrayType(null)],
			['NULL', new BooleanType(null)],
			['NULL', new FloatType(null)],
			['NULL', new IntegerType(null)],
			['NULL', new StringType(null)],
		];
   }
}