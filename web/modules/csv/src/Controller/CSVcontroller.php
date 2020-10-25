<?php

namespace Drupal\csv\Controller;

use Drupal\Core\Controller\ControllerBase;
// use Drupal\Core\Form\FormBase;
// use Drupal\Core\Form\FormStateInterface;
// use Drupal\Core\Url;


/**
 * Defines CSVController class.
 */
class CSVController extends ControllerBase {

  /**
   * Display the markup.
   *
   * @return array
   *   Return markup array.
   */
  public function content() {
    $build = [
      '#markup' => $this->t('Hello to the first module!'),
    ];
    return $build;
  }
  

  /**
   * default configuration
   */
  public function defaultConfiguration() {
    $default_config = \Drupal::config('csv.settings');
    return [
      'csv_block_name' => $default_config->get('csv.name'),
    ];
  }
}