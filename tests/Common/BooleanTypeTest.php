<?php
namespace Piggly\Tests\ValueTypes\Common;

use PHPUnit\Framework\TestCase;
use Piggly\ValueTypes\Common\BooleanType;
use stdClass;

/**
 * @coversDefaultClass \Piggly\ValueTypes\Common\BooleanType
 */
class BooleanTypeTest extends TestCase
{
	/**
	 * Assert if $value is validated as $expected.
	 *
	 * @covers ::parse
	 * @covers ::__construct
	 * @dataProvider dataValues
	 * @test Expecting positive assertion.
	 * @param boolean $expected Expected result.
	 * @param mixed $value Value to parse
	 * @return boolean
	 */
	public function canParse ( bool $expected, $value )
	{ $this->assertEquals($expected, (new BooleanType($value))->get()); }

	/**
	 * A list with random values to validate.
	 * Provider to canParse() method.
	 * @return array
	 */
	public function dataValues () : array
	{
		return [
			[true, true],
			[true, 'true'],
			[true, '1'],
			[true, 'string'],
			[true, [1,2,3]],
			[true, 1],
			[true, 1.5],
			[true, 2],
			[true, 2.5],
			[true, new stdClass()],
			[false, false],
			[false, 'false'],
			[false, '0'],
			[false, ''],
			[false, []],
			[false, 0],
			[false, 0.0]
		];
   }
}