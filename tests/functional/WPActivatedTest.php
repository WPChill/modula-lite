<?php

class WPActivatedTest extends \Codeception\TestCase\WPTestCase
{
    /**
     * @var \WpunitTester
     */
    protected $tester;

    /**
     * A single example test.
     */
    public function test_activation()
    {
        $this->assertTrue(defined('MODULA_LITE_VERSION'));
    }
    /**
     * Tests if a given shortcode exists
     *
     * @return void
     */
    public function test_shortcode_exists()
    {
        global $shortcode_tags;
        $this->assertTrue(array_key_exists('modula', $shortcode_tags) && array_key_exists('Modula', $shortcode_tags));

        $this->assertInstanceOf(Modula_Shortcode::class, $shortcode_tags['modula'][0]);
        $this->assertInstanceOf(Modula_Shortcode::class, $shortcode_tags['Modula'][0]);
    }
    /**
     * Test a gutenberg block
     *
     * @return void
     */
    public function test_gutenberg_block_exists()
    {
        $registry = WP_Block_Type_Registry::get_instance();
        $this->assertTrue($registry->is_registered('modula/gallery'));
    }
}
