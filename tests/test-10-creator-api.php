<?php
/**
 * Test class Creator_API
 */
class Creator_API extends WP_UnitTestCase {
	// protected $interaction_Boilerplate_Creator;
	protected $data;

	protected function setUp(): void {
		// Runs before each test method
		parent::setUp();

		$user_id = $this->factory()->user->create( array( 'role' => 'administrator' ) );
		wp_set_current_user( $user_id );

		include 'mock-data/form_data.php';

		$form_data['nonce']      = wp_create_nonce( 'wp_rest' );
		$form_data['form_nonce'] = wp_create_nonce( 'send_form_nonce' );

		$this->data = $form_data;
	}

	public function request_response(): array|null {
		$request = new WP_REST_Request( 'POST', '/interaction-boilerplate-creator/v1/submit-form' );

		$request->set_body_params( $this->data );

		$response = rest_get_server()->dispatch( $request );
		$response = $response->get_data();

		return $response;
	}

	public function testRestRoute(): void {
		$response = $this->request_response();

		// Assertions
		$this->assertArrayHasKey( 'status', $response );
		$this->assertArrayHasKey( 'logged_user', $response );
		$this->assertArrayHasKey( 'message', $response );
		$this->assertArrayHasKey( 'project_name', $response );
		$this->assertArrayHasKey( 'plugin_file_name', $response );
		$this->assertArrayHasKey( 'download_link', $response );

		$this->assertEquals( 200, $response['status'] );
		$this->assertEquals( true, $response['logged_user'] );
		$this->assertEquals( 'Boilerplate created successfully!', $response['message'] );
		$this->assertEquals( 'Example @ Boilerplate Creator', $response['project_name'] );
		$this->assertEquals( 'example-boilerplate-creator', $response['plugin_file_name'] );

		$upload_dir = wp_upload_dir();

		$filename = trailingslashit( $upload_dir['url'] ) . 'interaction-boilerplates/example-boilerplate-creator.zip';

		$this->assertEquals( $filename, $response['download_link'] );
	}

	public function test_invalid_nonce() {
		$this->data['nonce'] = '';

		$response = $this->request_response();

		$this->assertEquals( 'Invalid parameter(s): nonce', $response['message'] );
		$this->assertEquals( 400, $response['data']['status'] );
	}

	public function test_invalid_form_nonce() {
		$this->data['form_nonce'] = '';

		$response = $this->request_response();

		$this->assertEquals( 403, $response['status'] );
	}

	public function test_invalid_project_name(): void {
		$this->data['project_name'] = 'abcef  '; // project name trim length less than 5 - minimum 6

		$response = $this->request_response();

		$this->assertEquals( 'Please, insert a valid project name.', $response['message'] );
		$this->assertEquals( 204, $response['status'] );
	}

	public function test_invalid_email(): void {
		$this->data['plugin_author_email'] = 'invalid@email';

		$response = $this->request_response();

		$this->assertEquals( 'Please, insert a valid email.', $response['message'] );
		$this->assertEquals( 204, $response['status'] );
	}
}
