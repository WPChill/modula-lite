<?php

class WPAddonsTest extends \Codeception\TestCase\WPTestCase
{
    /**
     * @var \WpunitTester
     */
    protected $tester;
    // This is a bogus license
    private $license = '6638217e593ad02c7f5cd253fe509ab3';
    // This is a bogus download id
    private $download_id = '52222';
    // This is a bogus download slug
    private $download_slug = 'test-download';
    // This is a bogus download name
    private $download_name = 'Test Product';
    // Store url
    private $store_url = 'https://wp-modula.com';

    /**
     * Test get addons from remote source
     *
     * @return void
     */
    public function test_get_addons()
    {
        require_once MODULA_PATH . 'includes/admin/class-modula-addons.php';
        $addons = new Modula_Addons();
        // Assert that we do have addons
        $this->assertIsArray($addons->addons);
        // Assert that transients have been created
        $this->assertIsArray(get_transient('modula_all_extensions'));
    }
    /**
     * Test to see if you can activate a license on wp-modula.com
     *
     * @return void
     */
    public function test_license_activation()
    {
        $response = wp_remote_post(
            $this->store_url,
            [
                'timeout'   => 15,
                'sslverify' => false,
                'body'      => [
                    'edd_action' => 'activate_license',
                    'license'    => $this->license,
                    'item_id'    => $this->download_id,
                    'url'        => home_url(),
                ],
            ]
        );
        // Assert that we connected ok to the store
        $this->assertNotWPError($response);
        // Assert that the body is a string
        $this->assertIsString(wp_remote_retrieve_body($response));
        // Decode the data
        $data = json_decode(wp_remote_retrieve_body($response));
        // Assert that we have an object
        $this->assertInstanceOf(stdClass::class, $data);
        // Assert that the action was a success
        $this->assertTrue($data->success);
        // Assert that the license is valid
        $this->assertTrue($data->license === 'valid');
    }
    /**
     * Test to see if you can deactivate a license on wp-modula.com
     *
     * @return void
     */
    public function test_license_deactivation()
    {
        $response = wp_remote_post(
            $this->store_url,
            [
                'timeout'   => 15,
                'sslverify' => false,
                'body'      => [
                    'edd_action' => 'deactivate_license',
                    'license'    => $this->license,
                    'item_id'    => $this->download_id,
                    'url'        => home_url(),
                ],
            ]
        );
        // Assert that we connected ok to the store
        $this->assertNotWPError($response);
        // Assert that the body is a string
        $this->assertIsString(wp_remote_retrieve_body($response));
        // Decode the data
        $data = json_decode(wp_remote_retrieve_body($response));
        // Assert that we have an object
        $this->assertInstanceOf(stdClass::class, $data);
        // Assert that the action was a success
        $this->assertTrue($data->success);
        // Assert that the license is valid
        $this->assertTrue($data->license === 'deactivated');
    }
}
