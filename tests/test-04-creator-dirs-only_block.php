<?php
/**
 * Test class Creator_Dirs_Only_Block
 */
class Creator_Dirs_Only_Block extends WP_UnitTestCase {
	// protected $interaction_Boilerplate_Creator;
	// protected $couplets;
	protected $directories;

	protected function setUp(): void {
		// Runs before each test method
		parent::setUp();
		// $this->interaction_Boilerplate_Creator = new Interaction_Boilerplate_Creator_Main(); // The class is loaded automatically here

		// require_once plugin_dir_path( __DIR__ ) . 'includes/formatData/class-interaction-boilerplate-creator-main.php';
		// require_once plugin_dir_path( __DIR__ ) . 'includes/formatData/class-Interaction_Boilerplate_Creator_Dirs.php';

		// include 'mock-data/form_data.php';

		// $this->couplets = Interaction_Boilerplate_Creator_Couplets::FORMAT( $form_data );

		$form_data['plugin_type']       = 'only_block';
		$form_data['plugin_block_type'] = 'render';

		$this->directories = Interaction_Boilerplate_Creator_Dirs::CREATE( $form_data );
	}

	public function test_directories(): void {
		$this->assertIsArray( $this->directories['plugin_directories'] );

		$this->assertArrayHasKey( 'interaction', $this->directories['plugin_directories'] );
		$this->assertArrayHasKey( 'languages', $this->directories['plugin_directories'] );
		$this->assertArrayHasKey( 'assets', $this->directories['plugin_directories'] );
		$this->assertArrayHasKey( 'blocks', $this->directories['plugin_directories'] );
		$this->assertArrayHasKey( 'blocks_source', $this->directories['plugin_directories'] );

		$this->assertArrayNotHasKey( 'activation', $this->directories['plugin_directories'] );
		$this->assertArrayNotHasKey( 'includes', $this->directories['plugin_directories'] );
		$this->assertArrayNotHasKey( 'admin', $this->directories['plugin_directories'] );
		$this->assertArrayNotHasKey( 'admin_partials', $this->directories['plugin_directories'] );
		$this->assertArrayNotHasKey( 'admin_js', $this->directories['plugin_directories'] );
		$this->assertArrayNotHasKey( 'admin_css', $this->directories['plugin_directories'] );
		$this->assertArrayNotHasKey( 'public', $this->directories['plugin_directories'] );
		$this->assertArrayNotHasKey( 'public_partials', $this->directories['plugin_directories'] );
		$this->assertArrayNotHasKey( 'public_js', $this->directories['plugin_directories'] );
		$this->assertArrayNotHasKey( 'public_css', $this->directories['plugin_directories'] );
	}
}
