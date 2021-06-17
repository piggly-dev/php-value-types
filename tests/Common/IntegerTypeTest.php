<?php
namespace Piggly\Tests\ValueTypes\Common;

use PHPUnit\Framework\TestCase;
use Piggly\ValueTypes\Common\IntegerType;
use stdClass;

/**
 * @coversDefaultClass \Piggly\ValueTypes\Common\IntegerType
 */
class IntegerTypeTest extends TestCase
{
	/**
	 * Assert if $value is validated as $expected.
	 *
	 * @covers ::parse
	 * @covers ::__construct
	 * @dataProvider dataValues
	 * @test Expecting positive assertion.
	 * @param int $expected Expected result.
	 * @param mixed $value Value to parse
	 * @return boolean
	 */
	public function canParse ( int $expected, $value )
	{ $this->assertEquals($expected, (new IntegerType($value))->get()); }

	/**
	 * A list with random values to validate.
	 * Provider to canParse() method.
	 * @return array
	 */
	public function dataValues () : array
	{
		return [
			[42, 42],
			[4, 4.2],
			[42, '42'],
			[42, '+42'],
			[-42, '-42'],
			[-42, -42],
			[34, 042],
			[10000000000, 1e10], // 64-bit
			[10000000000, '1e10'], // 64-bit
			[26, 0x1A],
			[42000000, 42000000],
			[-4275113695319687168, 420000000000000000000], // 64-bit
			[9223372036854775807, '420000000000000000000'], // 64-bit
			[1, 'true'],
			[0, 'false'],
			[1500, '1,500.99'],
			[1500, '$ 1,500.99'],
			[-1500, '-1,500.99'],
			[-1500, '$ -1,500.99'],
			[0, 'string'],
			[1, true],
			[0, false],
			[1, [1,2,3]],
			[0, []],
			[0, new stdClass()]
		];
   }
}