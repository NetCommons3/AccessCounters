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
 * use components
 *
 * @var array
 */
	public $components = array(
		'Blocks.BlockTabs' => array(
			'mainTabs' => array('block_index', 'frame_settings'),
			'blockTabs' => array('block_settings'),
		),
		'NetCommons.Permission' => array(
			//アクセスの権限
			'allow' => array(
				'edit' => 'page_editable',
			),
		),
	);

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		if ($this->request->isPut() || $this->request->isPost()) {
			//登録(PUT)処理
			$data = $this->data;
			$data['AccessCounterFrameSetting']['display_type'] = (int)$data['AccessCounterFrameSetting']['display_type'];

			if ($this->AccessCounterFrameSetting->saveAccessCounterFrameSetting($data)) {
				$this->redirect(NetCommonsUrl::backToPageUrl());
				return;
			}
			$this->NetCommons->handleValidationError($this->AccessCounterFrameSetting->validationErrors);

		} else {
			//初期データセット
			$this->request->data = $this->AccessCounterFrameSetting->getAccessCounterFrameSetting(true);
			$this->request->data['Frame'] = Current::read('Frame');
		}
	}
}
