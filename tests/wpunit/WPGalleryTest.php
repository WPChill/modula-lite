<?php

class WPGalleryTest extends \Codeception\TestCase\WPTestCase
{
    /**
     * @var \WpunitTester
     */
    protected $tester;
    /**
     * Gallery id
     *
     * @var [type]
     */
    public $gallery_id;
    /**
     * Main DOM
     *
     * @var [type]
     */
    public $dom;
    /**
     * Dom gallery
     *
     * @var [type]
     */
    public $domGallery;
    /**
     * Gallery config
     *
     * @var [type]
     */
    public $galleryConfig;
    /**
     * Create gallery
     *
     * @return void
     */
    private function __create_gallery()
    {
        // Create a new post
        $gallery = $this->factory->post->create([
            'post_title'  => 'Modula test gallery',
            'post_type'   => 'modula-gallery',
            'post_status' => 'publish',
        ]);
        $this->assertIsInt($gallery);

        $this->gallery_id = $gallery;
        // We have a gallery now - we need to add images to it
        $attachments = $this->_upload_images();
        // Assert that we have 10 images uploaded
        $this->assertTrue(count($attachments) === 10);
        // Create the gallery array from the uploaded images
        $galleryImages = $this->_create_gallery_array($attachments);
        // Assert that the gallery was added as post meta
        $this->assertIsInt(update_post_meta($this->gallery_id, 'modula-images', $galleryImages));
    }
    /**
     * A single example test.
     */
    public function test_create()
    {
        $this->__create_gallery();
        // Create shortcode
        $shortcode = new Modula_Shortcode();
        // Create html output
        $html = $shortcode->gallery_shortcode_handler(['id' => $this->gallery_id]);
        // Assert that gallery exists
        $this->assertStringNotContainsString('Gallery not found.', $html);
        // Start preparing data sent to frontend
        $this->prepareData($html);
        // Assert the defaults
        $this->startAssertingDefaults($html);
    }
    /**
     * Test duplicate
     *
     * @return void
     */
    public function test_duplicate_function()
    {
        $this->__create_gallery();
        $this->assertTrue(function_exists('modula_duplicate_gallery_create_duplicate'));
        // Post that we need to "duplicate"
        $old_gallery = get_post($this->gallery_id);
        // This should return an int ( the new post id )
        $new_gallery = modula_duplicate_gallery_create_duplicate($old_gallery);
        // Assert that we have an int
        $this->assertIsInt($new_gallery);
        // Assert that the title match what we need to look like after a duplicate
        $this->assertTrue(get_the_title($new_gallery) === 'Copy of ' . get_the_title($old_gallery));
    }
    /**
     * Upload images and return the array of ids
     *
     * @return array
     */
    private function _upload_images()
    {
        $attachments = [];
        for ($i = 1; $i <= 10; $i++) {
            $attachments[] = $this->factory->attachment->create_upload_object(dirname(__DIR__) . '/_data/images/test-image-' . $i . '.jpeg');
        }
        return $attachments;
    }

    /**
     * Creates the gallery array
     *
     * @param [type] $images
     * @return array
     */
    private function _create_gallery_array($images)
    {
        $meta_arr = [];
        foreach ($images as $idx => $image) {
            $meta_arr[] = $this->_create_image_array($image, $idx);
        }
        return $meta_arr;
    }
    /**
     * Creates an image array
     *
     * @param [type] $id
     * @param [type] $index
     * @return array
     */
    private function _create_image_array($id, $index)
    {
        $currIndex = $index + 1;
        return [
            'id'          => $id,
            'title'       => 'Test image ' . $currIndex,
            'alt'         => 'Test image ' . $currIndex,
            'description' => 'Test image ' . $currIndex,
            'halign'      => 'center',
            'valign'      => 'middle',
            'link'        => '',
            'target'      => 0,
            'width'       => 2,
            'height'      => 2,
        ];
    }
    /**
     * Prepare data
     *
     * @param [string] $html
     * @return void
     */
    public function prepareData($html)
    {
        // Create the dom document object
        $this->dom = new DOMDocument();
        // Load our HTML
        $this->dom->loadHTML($html);
        // Find the gallery
        $this->domGallery = $this->dom->getElementById('jtg-' . $this->gallery_id);
        // If its null - test should fail
        $this->assertNotNull($this->domGallery);
        // Create the gallery config object
        $this->galleryConfig = json_decode($this->domGallery->getAttribute('data-config'));
    }
    /**
     * Asserts the defaults
     *
     * @return void
     */
    public function startAssertingDefaults()
    {
        // Start assertions
        $this->_assertDefaultClass();
        $this->_assertDefaultOptions();
        $this->_assertSocials();
        $this->_assertImages();
    }
    /**
     * Assert default class
     *
     * @return void
     */
    private function _assertDefaultClass()
    {
        $class = $this->domGallery->getAttribute('class');
        $this->assertTrue($class === 'modula modula-gallery modula-creative-gallery');
    }
    /**
     * Asserts default options
     *
     * @return void
     */
    private function _assertDefaultOptions()
    {
        $options = [
            'lightbox'          => 'fancybox',
            'effect'            => 'pufrobo',
            'enable_responsive' => 0,
            'type'              => 'creative-gallery',
        ];
        foreach ($this->galleryConfig as $key => $value) {
            if (array_key_exists($key, $options)) {
                $this->assertTrue($options[$key] === $value);
            }
        }

    }
    /**
     * Assert social status - everything should be false
     *
     * @return void
     */
    private function _assertSocials()
    {
        $socials = [
            'enableTwitter'   => false,
            'enableFacebook'  => false,
            'enableWhatsapp'  => false,
            'enablePinterest' => false,
            'enableLinkedin'  => false,
            'enableEmail'     => false,
        ];

        foreach ($this->galleryConfig as $key => $value) {
            if (array_key_exists($key, $socials)) {
                $this->assertTrue($socials[$key] === $value);
            }
        }
    }

    /**
     * Asserts the images sent to frontend
     *
     * @return void
     */
    private function _assertImages()
    {
        $xpath          = new DOMXpath($this->dom);
        $imageContainer = $xpath->query("//div[contains(concat(' ', normalize-space(@class), ' '), ' modula-items ')]");
        $items          = $xpath->query("//div[contains(concat(' ', normalize-space(@class), ' '), ' modula-item ')]");
        // Assert that this exists
        $this->assertTrue($imageContainer->length === 1);
        // Assert that we have 10 items
        $this->assertTrue($items->length === 10);
        // We need to get first item and start asserting the default values
        $firstItem = $items->item(0);
        // Default effect is pufrobo
        $this->assertTrue($firstItem->getAttribute('class') === 'modula-item effect-pufrobo');
        // We only have 2 child nodes ( overlay and img container )
        $this->assertTrue(intval(($xpath->evaluate('count(*)', $firstItem))) === 2);
        $images = $this->dom->getElementsByTagName('img');
        // Assert that we have 10 images
        $this->assertTrue($images->length === 10);
        // We need to get first value and start asserting the default values
        $firstImage = $images->item(0);
        // Assert class
        $this->assertTrue($firstImage->getAttribute('class') === 'pic');
        // Assert default halign
        $this->assertTrue($firstImage->getAttribute('data-halign') === 'center');
        // Assert default valign
        $this->assertTrue($firstImage->getAttribute('data-valign') === 'middle');
    }
}
