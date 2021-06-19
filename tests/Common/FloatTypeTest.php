<?php
namespace Piggly\Tests\ValueTypes\Common;

use PHPUnit\Framework\TestCase;
use Piggly\ValueTypes\Common\FloatType;
use stdClass;

/**
 * @coversDefaultClass \Piggly\ValueTypes\Common\FloatType
 */
class FloatTypeTest extends TestCase
{
	/**
	 * Assert if $value is validated as $expected.
	 *
	 * @covers ::parse
	 * @covers ::__construct
	 * @dataProvider dataValues
	 * @test Expecting positive assertion.
	 * @param float $expected Expected result.
	 * @param mixed $value Value to parse
	 * @return boolean
	 */
	public function canParse ( float $expected, $value )
	{ $this->assertEquals($expected, (new FloatType($value))->get()); }

	/**
	 * A list with random values to validate.
	 * Provider to canParse() method.
	 * @return array
	 */
	public function dataValues () : array
	{
		return [
			[1.0, '1'],
			[2.5, '2.5'],
			[2.e5, '2.e5'],
			[1.0, 1],
			[2.5, 2.5],
			[-1.0, '-1'],
			[-2.5, '-2.5'],
			[-2.e5, '-2.e5'],
			[-1.0, -1],
			[-2.5, -2.5],
			[1.0, 'true'],
			[0.0, 'false'],
			[1500.99, '1,500.99'],
			[1500.99, '$ 1,500.99'],
			[-1500.99, '-1,500.99'],
			[-1500.99, '$ -1,500.99'],
			[0.0, 'string'],
			[1.0, true],
			[0.0, false],
			[1.0, [1,2,3]],
			[0.0, []],
			[0.0, new stdClass()]
		];
   }
}