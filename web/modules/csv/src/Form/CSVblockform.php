<?php

namespace Drupal\csv\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
Use Drupal\Core\File\FileSystemInterface;
use Drupal\file\Entity\File;

/**
 * csv block form
 */
class CSVBlockForm extends FormBase {

	/**
	 * {@inheritdoc}
	 */
	public function getFormId() {
		return 'csv_block_form';
	}

	/**
	 * render configuration form
	 */

	public function buildForm( $form, FormStateInterface $form_state) {
		$form = array();
		$form['upload'] = array(
			'#type' => 'file',
			'#title' => t('Upload CSV file'),
			'#description' => t('Upload a file, allowed extensions: csv'),
			'#upload_validators' => array(
				'file_validate_extensions' => array('csv'),
			),
		);
		$form['submit_button'] = array(
			'#type' => 'submit',
			'#value' => t('Submit'),
		);
		return $form;
	}

	public function validateForm(array &$form, FormStateInterface $form_state) {
		$this->file = file_save_upload('upload', $form['upload']['#upload_validators'], FALSE, 0);
		if (!$this->file) {
			$form_state->setErrorByName('upload', $this->t('Provided file is not a CSV file or is corrupted.'));
		}
	}

	public function submitForm(array &$form, FormStateInterface $form_state) {
		$file = $form_state->getValue('upload');

		$valid = array ('file_validate_extensions' => array('csv'), );
		$location = 'homework/admin/jira/';
		$des = $location . time() . '-' . $_FILES['files']['name']['upload'];
		$new_file = file_save_upload( 'upload', $valid, $des );
		if($new_file) {
			$handle = fopen($new_file[0]->getFileUri(), "r");
			$arr = array();
			if ( $handle !== FALSE ) {
				$all = array();
				$header = fgetcsv($handle, ',');
				while ( $columns = fgetcsv($handle, ',') ) {
					$all = array_combine($header, $columns);
					$arr[] = $all;
				}
			}
			var_dump($arr);
			$header = file_move();
			fclose($handle);
		} else {
			$form_state->setErrorByName('upload', t('Failed to read the uploaded file.'));
		}
		return $arr;
	}

}
