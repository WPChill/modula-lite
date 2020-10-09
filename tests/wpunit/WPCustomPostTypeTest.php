<?php

class WPCustomPostTypeTest extends \Codeception\TestCase\WPTestCase
{
    /**
     * @var \WpunitTester
     */
    protected $tester;
    /**
     * A single example test.
     */
    public function test_post_type_exists()
    {        
        $this->assertTrue(post_type_exists('modula-gallery'));
    }
}
