<?php

class WPGalleryCreationCest
{
    /**
     * Create the gallery test
     *
     * @param AcceptanceTester $I
     * @return void
     */
    public function createGalleryTest(AcceptanceTester $I)
    {
        $I->wantTo('Want to create a gallery');
        $I->loginAsAdmin();
        $I->see('Dashboard');
        $I->amOnAdminPage('/post-new.php?post_type=modula-gallery');
        $I->see('Gallery');
        $I->fillField('#title', "Acceptance Test - Test Gallery Creation");
        for ($i = 1; $i <= 10; $i++) {
            $I->attachFile('//div[contains(@class, "moxie-shim")][1]//input', 'images/test-image-' . $i . '.jpeg');
        }
        $I->wait(5);
        $I->click('#publish');
        $I->wait(5);
        $I->makeScreenshot('gallery-saved');
    }
    /**
     * Get the shortcode and place it in the frontend
     *
     * @param AcceptanceTester $I
     * @return void
     */
    public function getShortcodeOfLatestGalleryTest(AcceptanceTester $I)
    {
        $I->wantTo('Want to display a gallery in the frontend');
        $I->loginAsAdmin();
        $I->see('Dashboard');
        $I->amOnAdminPage('/edit.php?post_type=modula-gallery');
        $I->click('//div[contains(@class,"modula-copy-shortcode")][1]//a');
        $I->see('Shortcode copied');
        $shortcode = $I->grabAttributeFrom('//div[contains(@class,"modula-copy-shortcode")][1]//input', 'value');
        $I->amOnAdminPage('/post-new.php?post_type=page');
        $I->fillField('#post-title-0', "Test gallery");
        $I->click('//button[contains(@class,"components-button")][1]');
        $I->see('Search for a block');
        $I->fillField('//input[contains(@class,"block-editor-inserter__search-input")]', 'shortcode');
        $I->click('//button[contains(@class,"editor-block-list-item-shortcode")][1]');
        $I->see('Shortcode');
        $I->fillField('#blocks-shortcode-input-0', $shortcode);
        $I->click('Publish');
        $I->click('//div[contains(@class, "editor-post-publish-panel__header-publish-button")][1]//button[contains(@class,"editor-post-publish-button__button")][1]');
        $I->wait(4);
        $I->click('//div[contains(@class, "post-publish-panel__postpublish-buttons")][1]//a');
        $I->wait(5);
        $I->makeScreenshot('result-shortcode');
    }
}
