<?php
/**
 * Test class Creator_Dirs_Full
 */
class Creator_Dirs_Full extends WP_UnitTestCase {
	// protected $interaction_Boilerplate_Creator;
	// protected $couplets;
	protected $directories;

	protected function setUp(): void {
		// Runs before each test method
		parent::setUp();
		// $this->interaction_Boilerplate_Creator = new Interaction_Boilerplate_Creator_Main(); // The class is loaded automatically here

		// include 'mock-data/form_data.php';

		// $this->couplets = Interaction_Boilerplate_Creator_Couplets::FORMAT_COUPLETS( $form_data );

		$form_data['plugin_type']       = 'full';
		$form_data['plugin_block_type'] = 'save';

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
		$this->assertArrayHasKey( 'blocks', $this->directories['plugin_directories'] );
		$this->assertArrayHasKey( 'blocks_source', $this->directories['plugin_directories'] );

		$this->assertEquals( 'languages/', $this->directories['plugin_directories']['languages'] );
		$this->assertEquals( 'assets/', $this->directories['plugin_directories']['assets'] );
		$this->assertEquals( 'activation/', $this->directories['plugin_directories']['activation'] );
		$this->assertEquals( 'includes/', $this->directories['plugin_directories']['includes'] );
		$this->assertEquals( 'interaction/admin/', $this->directories['plugin_directories']['admin'] );
		$this->assertEquals( 'interaction/admin/partials/', $this->directories['plugin_directories']['admin_partials'] );
		$this->assertEquals( 'interaction/admin/js/', $this->directories['plugin_directories']['admin_js'] );
		$this->assertEquals( 'interaction/admin/css/', $this->directories['plugin_directories']['admin_css'] );
		$this->assertEquals( 'interaction/public/', $this->directories['plugin_directories']['public'] );
		$this->assertEquals( 'interaction/public/partials/', $this->directories['plugin_directories']['public_partials'] );
		$this->assertEquals( 'interaction/public/js/', $this->directories['plugin_directories']['public_js'] );
		$this->assertEquals( 'interaction/public/css/', $this->directories['plugin_directories']['public_css'] );
	}
}
