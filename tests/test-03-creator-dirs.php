<?php
/**
 * Test class Creator_Dirs
 */
class Creator_Dirs extends WP_UnitTestCase {
	// protected $interaction_Boilerplate_Creator;
	protected $directories;

	protected function setUp(): void {
		// Runs before each test method
		parent::setUp();

		$form_data['plugin_type']       = 'full';
		$form_data['plugin_block_type'] = 'render';

		$this->directories = Interaction_Boilerplate_Creator_Dirs::CREATE( $form_data );
	}

	public function test_directories(): void {
		$this->assertIsArray( $this->directories );

		$haystack = $this->directories['source_dir'];
		$needle   = 'wp-content/plugins/interaction-boilerplate-creator/includes/boilerplate_source_files/';
		$message  = 'The source_dir should contain path to interaction-boilerplate-creator/includes/boilerplate_source_files/';
		$this->assertStringContainsString( $needle, $haystack, $message );

		$haystack = $this->directories['upload_boilerplates_dir'];
		$needle   = 'interaction-boilerplates/';
		$message  = 'The upload_boilerplates_dir should contain path to interaction-boilerplates/';
		$this->assertStringContainsString( $needle, $haystack, $message );

		$haystack = $this->directories['upload_boilerplates_url'];
		$needle   = 'http';
		$message  = 'The upload_boilerplates_url should contain http protocol';
		$this->assertStringContainsString( $needle, $haystack, $message );
	}
}
