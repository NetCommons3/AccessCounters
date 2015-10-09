<?php
/**
 * AccessCounters Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AccessCountersAppController', 'AccessCounters.Controller');

/**
 * AccessCounters Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\AccessCounters\Controller
 */
class AccessCountersController extends AccessCountersAppController {

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'Blocks.BlockTabs' => array(
			'mainTabs' => array('block_index', 'frame_settings'),
			'blockTabs' => array(
				'block_settings' => array('url' => array('controller' => 'access_counters'))
			),
		),
		'NetCommons.Permission' => array(
			//アクセスの権限
			'allow' => array(
				'add,edit,delete' => 'block_editable',
			),
		),
	);

/**
 * view
 *
 * @return void
 * @throws Exception
 */
	public function view() {
		if (! Current::read('Block.id')) {
			$this->autoRender = false;
			return;
		}
		$isAccessed = 'block_key_' . Current::read('Block.key');

		//AccessCounterFrameSettingデータ取得
		$counterFrameSetting = $this->AccessCounterFrameSetting->getAccessCounterFrameSetting(true);
		$this->set('accessCounterFrameSetting', $counterFrameSetting['AccessCounterFrameSetting']);

		//AccessCounterデータ取得
		$accessCounter = $this->AccessCounter->getAccessCounter(true);

		// カウントアップ処理
		if (! $this->Session->read($isAccessed)) {
			try {
				$this->AccessCounter->updateCountUp($accessCounter);
				$accessCounter['AccessCounter']['count']++;
				// アクセス情報を記録
				$this->Session->write($isAccessed, CakeSession::read('Config.userAgent'));

			} catch (Exception $ex) {
				CakeLog::error($ex);
				throw $ex;
			}
		}

		$this->set('accessCounter', $accessCounter['AccessCounter']);
	}

/**
 * add
 *
 * @return void
 */
	public function add() {
		//レイアウトの設定
		$this->layout = 'NetCommons.setting';
		$this->view = 'edit';

		if ($this->request->isPost()) {
			//登録(POST)処理
			$data = $this->data;
			$data['AccessCounter']['count'] = $data['AccessCounter']['count_start'];
			if ($this->AccessCounter->saveAccessCounter($data)) {
				$this->redirect(NetCommonsUrl::backToIndexUrl('default_setting_action'));
				return;
			}
			$this->NetCommons->handleValidationError($this->AccessCounter->validationErrors);

		} else {
			//初期データセット
			//--AccessCounter
			$this->request->data = Hash::merge(
				$this->request->data,
				$this->AccessCounter->createAll(array(
					'AccessCounter' => array(
						'id' => null,
					),
					'Block' => array(
						'name' => __d('access_counters', 'New Counter %s', date('YmdHis')),
					),
				))
			);
			//--AccessCounterFrameSetting
			$this->request->data = Hash::merge(
				$this->request->data,
				$this->AccessCounterFrameSetting->getAccessCounterFrameSetting(true)
			);
			//--Frame
			$this->request->data['Frame'] = Current::read('Frame');
		}
	}

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		//レイアウトの設定
		$this->layout = 'NetCommons.setting';

		if ($this->request->isPut()) {
			//登録(PUT)処理
			$data = $this->data;
			unset($data['AccessCounter']['count_start']);

			if ($this->AccessCounter->saveAccessCounter($data)) {
				$this->redirect(NetCommonsUrl::backToIndexUrl('default_setting_action'));
				return;
			}
			$this->NetCommons->handleValidationError($this->AccessCounter->validationErrors);

		} else {
			//--Block
			if (! $this->request->data['Block'] = Current::read('Block')) {
				$this->throwBadRequest();
				return false;
			}
			//--AccessCounter
			if (! $accessCounter = $this->AccessCounter->getAccessCounter(false)) {
				$this->throwBadRequest();
				return false;
			}
			$this->request->data = Hash::merge($this->request->data, $accessCounter);
			//--AccessCounterFrameSetting
			$this->request->data = Hash::merge(
				$this->request->data,
				$this->AccessCounterFrameSetting->getAccessCounterFrameSetting(true)
			);
			//--Frame
			$this->request->data['Frame'] = Current::read('Frame');
		}
	}

/**
 * delete
 *
 * @return void
 */
	public function delete() {
		if ($this->request->isDelete()) {
			if ($this->AccessCounter->deleteAccessCounter($this->data)) {
				$this->redirect(NetCommonsUrl::backToIndexUrl('default_setting_action'));
				return;
			}
		}
		$this->throwBadRequest();
	}
}
