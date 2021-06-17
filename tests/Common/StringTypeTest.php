<?php
namespace Piggly\Tests\ValueTypes\Common;

use PHPUnit\Framework\TestCase;
use Piggly\ValueTypes\Common\StringType;
use stdClass;

/**
 * @coversDefaultClass \Piggly\ValueTypes\Common\StringType
 */
class StringTypeTest extends TestCase
{
	/**
	 * Assert if $value is validated as $expected.
	 *
	 * @covers ::parse
	 * @covers ::__construct
	 * @dataProvider dataValues
	 * @test Expecting positive assertion.
	 * @param string $expected Expected result.
	 * @param mixed $value Value to parse
	 * @return boolean
	 */
	public function canParse ( string $expected, $value )
	{ $this->assertEquals($expected, (new StringType($value))->get()); }

	/**
	 * A list with random values to validate.
	 * Provider to canParse() method.
	 * @return array
	 */
	public function dataValues () : array
	{
		return [
			['true', true],
			['true', 'true'],
			['1', '1'],
			['string', 'string'],
			['[1,2,3]', [1,2,3]],
			['[{"key":"value"}]', [['key'=>'value']]],
			['1', 1],
			['1.5', 1.5],
			['2', 2],
			['2.5', 2.5],
			['stdClass', new stdClass()],
			['false', false],
			['false', 'false'],
			['0', '0'],
			['0.0', '0.0'],
			['', ''],
			['[]', []],
		];
   }
}