<?php
/**
 * AccessCounterFrameSettingsController Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AccessCountersAppController', 'AccessCounters.Controller');

/**
 * AccessCounterFrameSettingsController Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\AccessCounters\Controller
 */
class AccessCounterFrameSettingsController extends AccessCountersAppController {

/**
 * layout
 *
 * @var array
 */
	public $layout = 'NetCommons.setting';

/**
 * use models
 *
 * @var array
 */
	public $uses = array(
		'AccessCounters.AccessCounterFrameSetting'
	);

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsRoomRole' => array(
			//コンテンツの権限設定
			'allowedActions' => array(
				'pageEditable' => array('edit')
			),
		),
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();

		//タブの設定
		$this->initTabs('frame_settings', '');
	}

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		if (! $this->NetCommonsFrame->validateFrameId()) {
			$this->throwBadRequest();
			return false;
		}
		$this->initAccessCounter();

		$data = array();
		if ($this->request->isPost()) {
			$data = $this->data;
			$data['AccessCounterFrameSetting']['display_type'] = (int)$data['AccessCounterFrameSetting']['display_type'];

			$this->AccessCounterFrameSetting->saveAccessCounterFrameSetting($data);
			if ($this->handleValidationError($this->AccessCounterFrameSetting->validationErrors)) {
				if (! $this->request->is('ajax')) {
					$this->redirect('/' . $this->viewVars['cancelUrl']);
				}
				return;
			}
			$data = $this->camelizeKeyRecursive($data);
		}

		$results = $this->camelizeKeyRecursive($data);
		$results = Hash::merge(
			$this->viewVars, $results
		);
		$this->set($results);
	}
}
