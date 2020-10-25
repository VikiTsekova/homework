<?php

namespace Drupal\csv\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;


/**
 * Provides a 'csv' Block.
 *
 * @Block(
 *   id = "csv_block",
 *   admin_label = @Translation("CSV block"),
 *   category = @Translation("CSV"),
 * )
 */
class CSVblock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->getConfiguration();

    if (!empty($config['csv_block_name'])) {
      $name = $config['csv_block_name'];
    }
    else {
      $name = $this->t('nothing');
    }

    return [
      '#markup' => $this->t('HI @name!', [
        '@name' => $name,
        ]),
        '#theme' => 'my_template',
        '#test_var' => $this->t('Test Value'),
    
    ];
    // return [
    //   '#markup' => $this->t('csv'),
      
    // ];
  }

  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['csv_block_name'] = $form_state->getValue('csv_block_name');
    //$this->configuration['csv_block_name'] = $form_state->getValue(['myfieldset', 'csv_block_name']);

  }
}
