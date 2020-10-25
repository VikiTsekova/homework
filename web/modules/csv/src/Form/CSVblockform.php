<?php

namespace Drupal\csv\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

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

	function csv_form_alter(array &$form, FormStateInterface $form_state, $form_id) {
		$form['#validate'][] = 'csv_validate';
	}

	public function validateForm(array &$form, FormStateInterface $form_state) {
		// parent::validateForm($form, $form_state);

    // $session = \Drupal::request()->getSession();
		// $session->set('upload', $session->get('upload') + 1);
		$validators['file_validate_extensions'] = array('csv');
		$fileData = explode('.', $_FILES['files']['name']['upload']);
		if( $fileData[1] != 'csv' ){
			$form_state->setErrorByName('upload', t('Please upload csv file!'));
		}
		$tempfile = file_save_upload('upload', $validators );
		if ( $tempfile === FALSE ) {
			form_set_error('upload', t("Failed to upload the csv file"));
		} elseif ( $tempfile !== NULL ) {
			$tempfile = $form_state->getValue('upload');
		}
		var_dump($tempfile);
	}

	public function submitForm(array &$form, FormStateInterface $form_state) {
		// $session = \Drupal::request()->getSession();
		// $session->set('upload', $session->get('upload') + 1);

		// $fid = $form_state->set('upload', $form_state->get('upload') + 1);


		$val = $form_state->getValue('upload');
		var_dump($val);
		$f = \Drupal\file\Entity\File::load($val);
		$handle = fopen($f->getFileUri(),"r");
		 while ($data = fgetcsv($handle, 100000, ",")) {
			$arr = [];
			if($int==0 && count($data)!=24){
				$form_state->setErrorByName("upload","Error csv format.");
				$continue = FALSE;
			}
			$eventstart = strtotime($data[4]);
			if($eventstart){
				$arr['eventstart']=$eventstart;
			} else {
				$form_state->setErrorByName("upload",$data[4]. " is not a valid Date.");
			}
			fclose($handle);
			//package all data into $list array
			$list = [];
			$form_state->setValue('upload', $list );
		}

	}

}