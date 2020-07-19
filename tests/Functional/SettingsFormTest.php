<?php

namespace Drupal\Tests\drupal8_functional_demo\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Test the module settings page
 *
 * @group drupal8_functional_demo
 */
class SettingsFormTest extends BrowserTestBase {

    const FORM_PATH = '/admin/config/system/drupal8_functional_demo';

    public static $modules = [
      'drupal8_functional_demo'
    ];

    protected $defaultTheme = 'seven';

    protected function setUp()
    {
        parent::setUp();

        $account = $this->drupalCreateUser(['administer site configuration']);
        $this->drupalLogin($account);
        $this->drupalGet(self::FORM_PATH);
    }

    public function textOnPage()
    {
        return [
            ['Example Configuration field']
        ];
    }

    public function fieldsAndValues()
    {
        return [
            ['example_config_field', 'testing 123']
        ];
    }

    public function testModuleDoesNotBreaksSite()
    {
        $this->assertSession()->statusCodeEquals(200);
    }

    /**
     * @dataProvider textOnPage
     */
    public function testInputIsPresentOnPage($text)
    {
        $this->assertText($text);
    }

    /**
     * @dataProvider fieldsAndValues
     */
    public function testInputValueIsSaved($field, $value)
    {
        $this->drupalPostForm(
            self::FORM_PATH,
            [$field => $value],
            'Save configuration'
        );

        $this->drupalGet(self::FORM_PATH);
        $fieldValue = $this->assertSession()
            ->fieldExists($field)
            ->getValue();

        $this->assertTrue($fieldValue == $value);
    }
}
