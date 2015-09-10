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

		//タブの設定
		$this->initTabs('block_index', 'block_settings');

		if ($this->request->isPost()) {
			//登録(POST)処理
			$data = $this->__parseRequestData($this->data);
			if ($this->AccessCounter->saveAccessCounter($data)) {
				$this->redirect(Current::backToIndexUrl('default_setting_action'));
			}
			$this->handleValidationError($this->AccessCounter->validationErrors);

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

		//タブの設定
		$this->initTabs('block_index', 'block_settings');

		if ($this->request->isPut()) {
			//登録(PUT)処理
			$data = $this->data;
			unset($data['AccessCounter']['count_start']);

			$data = $this->__parseRequestData($data);
			if ($this->AccessCounter->saveAccessCounter($data)) {
				$this->redirect(Current::backToIndexUrl('default_setting_action'));
			}
			$this->handleValidationError($this->AccessCounter->validationErrors);

		} else {
			//初期データセット
			CurrentFrame::setBlock($this->request->params['pass'][1]);

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
				$this->redirect(Current::backToIndexUrl('default_setting_action'));
			}
		}
		$this->throwBadRequest();
	}

/**
 * Parse data from request
 *
 * @param array $data received post data
 * @return array
 */
	private function __parseRequestData($data) {
		if (isset($data['AccessCounterFrameSetting']['display_type'])) {
			$data['AccessCounterFrameSetting']['display_type'] = (int)$data['AccessCounterFrameSetting']['display_type'];
		}
		if (isset($data['AccessCounter']['count_start'])) {
			$data['AccessCounter']['count'] = (int)$data['AccessCounter']['count_start'];
		}
		return $data;
	}

}
