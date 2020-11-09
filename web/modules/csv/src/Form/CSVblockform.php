<?php

namespace Drupal\csv\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
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

		// $session = \Drupal::request()->getSession();

		// if (empty($session->get('upload'))) {
		// 	$session->set('upload', 1);
		// }

		return $form;
	}

	function session_get($session_name, $default) {
		if (isset($_SESSION[$session_name])) {
			return $_SESSION[$session_name];
		}
		return $default;
	}
	function session_set($session_name, $session_value) {
		$_SESSION[$session_name] = $session_value;
	}

	function csv_form_alter(array &$form, FormStateInterface $form_state, $form_id) {
		$form['#validate'][] = 'csv_validate';
	}

	public function validateForm(array &$form, FormStateInterface $form_state) {
		$validators['file_validate_extensions'] = array('csv');
		$fileData = explode('.', $_FILES['files']['name']['upload']);
		if( $fileData[1] != 'csv' ){
			$form_state->setErrorByName('upload', t('Please upload csv file!'));
		}
		$tempfile = file_save_upload('upload', $validators );
		if ( $tempfile ) {
			 $tempfile = $form_state->getValue('upload');
		} else {
			$form_state->setErrorByName('upload', t('The file can not be uploaded!'));
		}
	}

	public function submitForm(array &$form, FormStateInterface $form_state) {
		//$line = variable_get('user_import_line_max', 1000);
		//ini_set('auto_detect_line_endings', true);

		$file = $form_state->getValue('upload');
		$f = \Drupal\file\Entity\File::load($file);
		
		$file_real_path = \Drupal::service('file_system')->realpath($f->getFileUri());
		
		$handle = fopen($file_real_path, "r");
		
		$row = fgetcsv( $handle );
		$columns = [];

		while ( $row = fgetcsv( $handle ) ) {
		// $row is an array of elements in each row
		// e.g. if the first column is the email address of the user, try something like
		//$mail = $row[0];
		}
	}

}