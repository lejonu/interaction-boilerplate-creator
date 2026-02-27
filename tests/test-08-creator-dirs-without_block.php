<?php
/**
 * Test class Creator_Dir_Without_Block
 */
class Creator_Dir_Without_Block extends WP_UnitTestCase {
	// protected $interaction_Boilerplate_Creator;
	// protected $couplets;
	protected $directories;

	protected function setUp(): void {
		// Runs before each test method
		parent::setUp(); 
		// $this->interaction_Boilerplate_Creator = new Interaction_Boilerplate_Creator_Main(); // The class is loaded automatically here

		// include 'mock-data/form_data.php';

		// $this->couplets = Interaction_Boilerplate_Creator_Couplets::FORMAT_COUPLETS( $form_data );

		$form_data['plugin_type']       = 'without_block';
		$form_data['plugin_block_type'] = '';

		$this->directories = Interaction_Boilerplate_Creator_Dirs::CREATE( $form_data );
	}

	public function test_directories(): void {
		$this->assertIsArray( $this->directories['plugin_directories'] );

		$this->assertArrayHasKey( 'interaction', $this->directories['plugin_directories'] );
		$this->assertArrayHasKey( 'assets', $this->directories['plugin_directories'] );
		$this->assertArrayHasKey( 'languages', $this->directories['plugin_directories'] );
		$this->assertArrayHasKey( 'activation', $this->directories['plugin_directories'] );
		$this->assertArrayHasKey( 'includes', $this->directories['plugin_directories'] );
		$this->assertArrayHasKey( 'admin', $this->directories['plugin_directories'] );
		$this->assertArrayHasKey( 'admin_partials', $this->directories['plugin_directories'] );
		$this->assertArrayHasKey( 'admin_js', $this->directories['plugin_directories'] );
		$this->assertArrayHasKey( 'admin_css', $this->directories['plugin_directories'] );
		$this->assertArrayHasKey( 'public', $this->directories['plugin_directories'] );
		$this->assertArrayHasKey( 'public_partials', $this->directories['plugin_directories'] );
		$this->assertArrayHasKey( 'public_js', $this->directories['plugin_directories'] );
		$this->assertArrayHasKey( 'public_css', $this->directories['plugin_directories'] );

		$this->assertArrayNotHasKey( 'blocks', $this->directories['plugin_directories'] );
		$this->assertArrayNotHasKey( 'blocks_source', $this->directories['plugin_directories'] );
	}
}
