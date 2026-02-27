<?php
/**
 * Test class Creator_Zip
 */
class Creator_Zip extends WP_UnitTestCase {
	// protected $interaction_Boilerplate_Creator;
	// protected $couplets;
	protected $directories;
	protected $creat_zip;

	protected function setUp(): void {
		// Runs before each test method
		parent::setUp();
		// $this->interaction_Boilerplate_Creator = new Interaction_Boilerplate_Creator_Main(); // The class is loaded automatically here

		include 'mock-data/form_data.php';

		$form_data['plugin_type']       = 'full';
		$form_data['plugin_block_type'] = 'render';

		$this->directories = Interaction_Boilerplate_Creator_Dirs::CREATE( $form_data );

		// If files exists, remove before another test
		$filename = trailingslashit( $this->directories['upload_boilerplates_dir'] ) . 'example-boilerplate-creator.zip';

		if ( is_file( $filename ) ) {
			wp_delete_file( $filename );
		}

		$this->creat_zip = Interaction_Boilerplate_Creator_Zip::CREATE( $form_data );
	}

	public function test_zip_creation(): void {
		$this->assertIsArray( $this->creat_zip );

		$this->assertEquals( 200, $this->creat_zip['status'] );
		$this->assertEquals( 'Boilerplate created successfully!', $this->creat_zip['message'] );

		$this->assertEquals( 'Example @ Boilerplate Creator', $this->creat_zip['project_name'] );
		$this->assertEquals( 'example-boilerplate-creator', $this->creat_zip['plugin_file_name'] );

		$this->assertStringStartsWith( 'http', $this->creat_zip['download_link'], 'Should start with http protocol.' );
		$this->assertStringEndsWith( '/interaction-boilerplates/example-boilerplate-creator.zip', $this->creat_zip['download_link'], 'Should end with path to created file zip.' );

		$filename = $this->directories['upload_boilerplates_dir'] . DIRECTORY_SEPARATOR . 'example-boilerplate-creator.zip';
		$this->assertTrue( is_file( $filename ), 'Should be a zip file ' . $filename );
	}
}
