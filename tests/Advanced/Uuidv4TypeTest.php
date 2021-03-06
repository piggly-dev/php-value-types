<?php
namespace Piggly\Tests\ValueTypes\Advanced;

use PHPUnit\Framework\TestCase;
use Piggly\ValueTypes\Advanced\Uuidv4Type;

/**
 * @coversDefaultClass \Piggly\ValueTypes\Advanced\Uuidv4Type
 */
class Uuidv4TypeTest extends TestCase
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
	{ $this->assertEquals($expected, (new Uuidv4Type($value))->validate()); }

	/**
	 * A list with random values to validate.
	 * Provider to canValidate() method.
	 * - Generated by fakerphp.
	 * @return array
	 */
	public function dataValues () : array
	{
		return [
			[true, '4fc487dd-d9ba-478c-984d-911ce86c0a2e'],
			[true, '3720eb6f-adee-4d90-a718-1a4ed7bfe84d'],
			[true, '96381273-0efe-45d5-a67e-c7d1c3838134'],
			[true, '25d077b7-c66c-493f-ae87-50c6ee0b6244'],
			[true, 'fec10a6e-79b5-4135-b868-068c71ac5912'],
			[true, '9c71d379-c4e9-4213-9ab0-e7a0027f5dce'],
			[true, '539bbf52-4a35-47e6-93fb-fe47c2f53875'],
			[true, '634492c6-03b5-409d-8d6c-9f40052d96c0'],
			[true, '46400f6e-f6d7-4b5b-b99e-ceb6714c50fd'],
			[true, 'cb3362f1-9098-438a-bae0-eea80bbeee3f'],
			[true, 'c8217eda-6699-4acc-a801-1ddb1e9cdde7'],
			[true, '73fc142c-a7c2-4597-b9f7-48edfea5f808'],
			[true, '6cf52724-0eaa-4d7e-869e-f5e0ce353506'],
			[true, '42164101-1adf-4155-81fe-e7d32e684581'],
			[true, 'e9be2a6b-f499-4357-aa42-a3ca541bb887'],
			[true, 'd151c644-a656-4bc2-9be7-9af287e92e21'],
			[true, 'f5bc9958-be13-4fd5-a5d2-6609a84fb1a5'],
			[true, '38536f64-2bdd-4b95-be1d-99fadc870d7f'],
			[true, '42e8f570-ca52-4574-b57e-03d2155fa81a'],
			[true, '70ec30e7-4854-4bb2-a12d-0e9240d7c069'],
			[true, 'c9bafa8c-3773-462b-9f87-763dc782e8b3'],
			[true, '0cb31ca2-971a-4de2-96d6-6227978c71e0'],
			[true, '0575fa1e-c7cf-4f99-b408-6fd134d59cc2'],
			[true, '262bc844-1091-488f-83c2-7f1cc26445e5'],
			[true, 'f593c6c2-8276-4819-a3e7-9e6dbac1cb60'],
			[true, '362bdf52-57a7-4ec4-aa29-c65947eff62c'],
			[true, '39ce993b-a715-441f-aa79-1b3a5ca82f1a'],
			[true, '894375b5-e7be-4cd0-827f-a53583bf118f'],
			[true, 'cdaf5add-f20b-4afd-b4e2-62a71ad75af6'],
			[true, 'fe13e9b2-b725-44b8-b814-7ec951b5cd86'],
			[true, '76240937-406c-49fe-9b64-c2bc849b4f7b'],
			[true, '29d80dd4-af3d-41bb-83bc-6249baa8fd33'],
			[true, '7a5f1d87-467b-4667-be11-2d0880ac6c07'],
			[true, '6a2d07a6-9e5c-4879-bfda-847fba6de00c'],
			[true, 'ac2e38f6-dac6-4a42-86fb-1caecd8630ab'],
			[true, 'acf840d2-d301-44b3-b9fc-8c3054061e06'],
			[true, '1b42adaa-aca9-4002-b1f4-e58a64b1963a'],
			[true, '7648255a-c3f4-458a-b6b5-04b4aff409f7'],
			[true, '07ef04e7-2a95-436f-8f93-07596bee9156'],
			[true, '89db64ef-89ea-4303-aace-661e10646db6'],
			[true, '9839deb3-e673-440d-9bf8-7406f18c0543'],
			[true, '65be3dbd-5eef-41d7-aa83-672082257bab'],
			[true, '7d8108fb-2659-4188-8be7-94404f202635'],
			[true, '51c2e987-ea8b-42ef-afc6-07c297894ad7'],
			[true, '89e3dd4a-8e5f-442a-ae8b-480ee10e613d'],
			[true, 'd5c0ca89-c235-44a8-a909-39cd2f652d05'],
			[true, '55f9070a-efa6-488a-9d49-951b56fd66e5'],
			[true, 'c538ef48-aca2-410e-b1f2-f4ea512733e0'],
			[true, '08d97c6f-06a3-42c6-93af-3f42d6143ded'],
			[true, '5830e007-25f5-4dbc-9c8d-df73a67c0330'],
		];
   }
}