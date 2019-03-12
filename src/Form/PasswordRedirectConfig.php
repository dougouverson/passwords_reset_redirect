<?php

namespace Drupal\passwords_reset_redirect\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class PasswordRedirectConfig.
 */
class PasswordRedirectConfig extends ConfigFormBase {

  /**
   * Get the form_id.
   *
   * @inheritDoc
   */
  public function getFormId() {
    return 'passwords_reset_redirect_form';
  }

  /**
   * Build the Form.
   *
   * @inheritDoc
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('passwords_reset_redirect.settings');
    $form = [];
    $form['passwords_reset_redirect_fieldset'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Configure redirect after password reset'),
    ];

    $redirect_after_reset = ($config->get('redirect_after_reset')) ?: '/user';
    $form['passwords_reset_redirect_fieldset']['redirect_after_reset'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Redirect URL'),
      '#default_value' => $redirect_after_reset,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * Get Editable config names.
   *
   * @inheritDoc
   */
  protected function getEditableConfigNames() {
    return ['passwords_reset_redirect.settings'];
  }

  /**
   * Add validate handler.
   *
   * @inheritDoc
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
  }

  /**
   * Add submit handler.
   *
   * @inheritDoc
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $user_input_values = $form_state->getUserInput();
    $config = $this->configFactory->getEditable('passwords_reset_redirect.settings');
    $config->set('redirect_after_reset', $user_input_values['redirect_after_reset']);
    $config->save();
    parent::submitForm($form, $form_state);
  }

}
