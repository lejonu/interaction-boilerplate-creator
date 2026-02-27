<?php
/**
 * Test class Creator_Main
 */
class Creator_Main extends WP_UnitTestCase {
	protected $interaction_Boilerplate_Creator;
	protected $couplets;

	protected function setUp(): void {
		// Runs before each test method
		parent::setUp();

		require_once INTERACTION_BOILERPLATE_CREATOR_DIR . 'includes/formatData/class-interaction-boilerplate-creator-couplets.php';
		require_once INTERACTION_BOILERPLATE_CREATOR_DIR . 'includes/formatData/class-interaction-boilerplate-creator-dirs.php';
		require_once INTERACTION_BOILERPLATE_CREATOR_DIR . 'includes/formatData/class-interaction-boilerplate-creator-replace.php';

		require_once INTERACTION_BOILERPLATE_CREATOR_DIR . 'includes/log/class-interaction-boilerplate-creator-log.php';

		$this->interaction_Boilerplate_Creator = new Interaction_Boilerplate_Creator_Main(); // The class is loaded automatically here
	}

	public function test_instantiate(): void {
		$this->assertInstanceOf( Interaction_Boilerplate_Creator_Main::class, $this->interaction_Boilerplate_Creator );
	}

	public function test_dir_constant(): void {
		$this->assertTrue( defined( 'INTERACTION_BOILERPLATE_CREATOR_DIR' ), 'Plugin directory global constant should be defined.' );
	}

	// public function test_version(): void {
	// $version = $this->interaction_Boilerplate_Creator->get_version();
	// $this->assertEquals( $version, '1.0.0' );
	// }
}
