<?php
namespace Piggly\Tests\ValueTypes\Advanced;

use PHPUnit\Framework\TestCase;
use Piggly\ValueTypes\Advanced\PostalCodeType;

/**
 * @coversDefaultClass \Piggly\ValueTypes\Advanced\PostalCodeType
 */
class PostalCodeTypeTest extends TestCase
{
	/**
	 * Assert if $value is validated as $expected.
	 *
	 * @covers ::validate
	 * @covers ::assert
	 * @covers ::__construct
	 * @dataProvider dataValues
	 * @test Expecting positive assertion.
	 * @param boolean $expected Expected result.
	 * @param boolean $value Value to validate
	 * @return boolean
	 */
	public function canValidate ( bool $expected, string $value )
	{ $this->assertEquals($expected, (new PostalCodeType($value))->validate()); }

	/**
	 * A list with random values to validate.
	 * Provider to canValidate() method.
	 * - Generated by fakerphp.
	 * @return array
	 */
	public function dataValues () : array
	{
		$arr = [];
		$faker = \Faker\Factory::create();

		for ( $i = 0; $i < 50; $i++ )
		{ $arr[] = [true, $faker->regexify('[0-9]{5}')]; }

		return $arr;
   }
}