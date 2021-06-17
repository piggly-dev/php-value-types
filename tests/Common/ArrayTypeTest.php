<?php
namespace Piggly\Tests\ValueTypes\Common;

use PHPUnit\Framework\TestCase;
use Piggly\ValueTypes\Common\ArrayType;
use stdClass;

/**
 * @coversDefaultClass \Piggly\ValueTypes\Common\ArrayType
 */
class ArrayTypeTest extends TestCase
{
	/**
	 * Assert if $value is validated as $expected.
	 *
	 * @covers ::parse
	 * @covers ::__construct
	 * @dataProvider dataValues
	 * @test Expecting positive assertion.
	 * @param array $expected Expected result.
	 * @param mixed $value Value to parse
	 * @return boolean
	 */
	public function canParse ( array $expected, $value )
	{ $this->assertEquals($expected, (new ArrayType($value))->get()); }

	/**
	 * A list with random values to validate.
	 * Provider to canParse() method.
	 * @return array
	 */
	public function dataValues () : array
	{
		return [
			[[], 0],
			[[], '0'],
			[[], ''],
			[[], []],
			[[1,2,3], [1,2,3]],
			[[['key'=>'value']], [['key'=>'value']]],
			[[1,2,3], '[1,2,3]'],
			[[['key'=>'value']], '[{"key":"value"}]'],
		];
   }
}