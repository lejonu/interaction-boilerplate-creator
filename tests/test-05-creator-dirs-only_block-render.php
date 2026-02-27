<?php
/**
 * Test class Creator_Dirs_Only_Block_Render
 */
class Creator_Dirs_Only_Block_Render extends WP_UnitTestCase {
	// protected $interaction_Boilerplate_Creator;
	// protected $couplets;
	protected $directories;

	protected function setUp(): void {
		// Runs before each test method
		parent::setUp();
		// $this->interaction_Boilerplate_Creator = new Interaction_Boilerplate_Creator_Main(); // The class is loaded automatically here

		// include 'mock-data/form_data.php';

		// $this->couplets = Interaction_Boilerplate_Creator_Couplets::FORMAT( $form_data );

		$form_data['plugin_type']       = 'only_block';
		$form_data['plugin_block_type'] = 'render';

		$this->directories = Interaction_Boilerplate_Creator_Dirs::CREATE( $form_data );
	}

	public function test_directories(): void {
		$this->assertContains( 'interaction/blocks/src-render/', $this->directories['plugin_directories'], 'The Array should contain block render directory' );

		$this->assertNotContains( 'interaction/blocks/src-save/', $this->directories['plugin_directories'], 'The Array should not contain save block directory' );
	}
}
