<?php

namespace Drupal\drupal8_functional_demo\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class FunctionalDemoForm extends ConfigFormBase
{
    const CONFIG_NAME = 'drupal8_functional_demo.settings';

    private $formFields = [
        'example_config_field' => [
            'title' => 'Example Configuration field'
        ]
    ];

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'drupal8_functional_demo_settings';
    }

    /**
     * {@inheritdoc}
     */
    protected function getEditableConfigNames() {
        return [self::CONFIG_NAME];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        $config = $this->config(self::CONFIG_NAME);

        $form['settings'] = [
            '#type' => 'details',
            '#title' => t('Settings'),
            '#open' => TRUE,
        ];

        foreach($this->formFields as $field=>$property) {
            $form['settings'][$field] = [
                '#type' => 'textfield',
                '#title' => t($property['title']),
                '#default_value' => $config->get($field)
            ];
        }

        return parent::buildForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        foreach($this->formFields as $field=>$property) {
            $this->config(self::CONFIG_NAME)
            ->set($field, $form_state->getValue($field))
            ->save();
        }

        parent::submitForm($form, $form_state);
    }
}
