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
		'NetCommons.Permission' => array(
			//アクセスの権限
			'allow' => array(
				'edit' => 'page_editable',
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
		if ($this->request->isPut()) {
			//登録(PUT)処理
			$data = $this->data;
			$data['AccessCounterFrameSetting']['display_type'] = (int)$data['AccessCounterFrameSetting']['display_type'];

			if ($this->AccessCounterFrameSetting->saveAccessCounterFrameSetting($data)) {
				$this->redirect(Current::backToIndexUrl());
			}
			$this->handleValidationError($this->AccessCounterFrameSetting->validationErrors);

		} else {
			//初期データセット
			$this->request->data = $this->AccessCounterFrameSetting->getAccessCounterFrameSetting(true);
			$this->request->data['Frame'] = Current::read('Frame');
		}
	}
}
