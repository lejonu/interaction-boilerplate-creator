<?php
/**
 * Test class Creator_Couplets
 */
class Creator_Couplets extends WP_UnitTestCase {
	// protected $interaction_Boilerplate_Creator;
	protected $couplets;

	protected function setUp(): void {
		// Runs before each test method
		parent::setUp();

		include 'mock-data/form_data.php';

		$this->couplets = Interaction_Boilerplate_Creator_Couplets::FORMAT( $form_data );
	}

	public function test_couplets(): void {
		$this->assertIsArray( $this->couplets );

		$this->assertEquals( 'example-boilerplate-creator', $this->couplets['plugin_file_name'] );
		$this->assertEquals( 'example_boilerplate_creator', $this->couplets['plugin_function_name'] );
		$this->assertEquals( 'EXAMPLE_BOILERPLATE_CREATOR', $this->couplets['plugin_constant_name'] );
		$this->assertEquals( 'ExampleBoilerplateCreator', $this->couplets['plugin_package_name'] );
		$this->assertEquals( 'Example_Boilerplate_Creator', $this->couplets['plugin_class_name'] );
		$this->assertEquals( 'exampleBoilerplateCreator', $this->couplets['plugin_camel_name'] );
		$this->assertEquals( 'main-block', $this->couplets['plugin_block_name'] );
		$this->assertEquals( 'book', $this->couplets['plugin_block_icon'] );
	}
}
