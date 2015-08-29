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
 * use model
 *
 * @var array
 */
	public $uses = array(
		'AccessCounters.AccessCounter',
		'AccessCounters.AccessCounterFrameSetting',
	);

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsBlock',
		'NetCommons.NetCommonsRoomRole' => array(
			//コンテンツの権限設定
			'allowedActions' => array(
				'blockEditable' => array('add', 'edit', 'delete')
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
		if (! $this->viewVars['blockId']) {
			$this->autoRender = false;
			return;
		}
		$isAccessed = 'block_key_' . $this->viewVars['blockKey'];

		//AccessCounterFrameSettingデータ取得
		$counterFrameSetting = $this->AccessCounterFrameSetting->getAccessCounterFrameSetting($this->viewVars['frameKey'], true);
		$this->set('accessCounterFrameSetting', $counterFrameSetting['AccessCounterFrameSetting']);

		//AccessCounterデータ取得
		$accessCounter = $this->AccessCounter->getAccessCounter(
			$this->viewVars['blockKey'],
			$this->viewVars['roomId'],
			true
		);

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
				$this->redirect('/access_counters/access_counter_blocks/index/' . $this->viewVars['frameId']);
			}
			$this->handleValidationError($this->AccessCounter->validationErrors);

		} else {
			//初期データセット
			//--AccessCounter
			$this->request->data = Hash::merge($this->request->data, $this->AccessCounter->create(
				array(
					'id' => null,
					'block_key' => null,
				)
			));
			//--Block
			$this->request->data = Hash::merge($this->request->data, $this->Block->create(
				array(
					'id' => null,
					'key' => null,
					'name' => __d('access_counters', 'New Counter %s', date('YmdHis')),
					'language_id' => Configure::read('Config.languageId'),
					'room_id' => $this->viewVars['roomId'],
					'plugin_key' => $this->params['plugin']
				)
			));
			//--AccessCounterFrameSetting
			$this->request->data = Hash::merge(
				$this->request->data,
				$this->AccessCounterFrameSetting->getAccessCounterFrameSetting($this->viewVars['frameKey'], true)
			);
			//--Frame
			$this->request->data['Frame'] = array(
				'id' => $this->viewVars['frameId'],
				'key' => $this->viewVars['frameKey']
			);
		}
	}

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		if (! isset($this->params['pass'][1])) {
			$this->throwBadRequest();
			return false;
		}
		$this->set('blockId', (int)$this->params['pass'][1]);

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
				$this->redirect('/access_counters/access_counter_blocks/index/' . $this->viewVars['frameId']);
			}
			$this->handleValidationError($this->AccessCounter->validationErrors);

		} else {
			//初期データセット
			//--Block
			if (! $block = $this->AccessCounter->getBlock($this->viewVars['blockId'], $this->viewVars['roomId'])) {
				$this->throwBadRequest();
				return false;
			}
			$this->request->data = Hash::merge($this->request->data, $block);
			//--AccessCounter
			if (! $accessCounter = $this->AccessCounter->getAccessCounter(
				$block['Block']['key'],
				$this->viewVars['roomId'],
				false
			)) {
				$this->throwBadRequest();
				return false;
			}
			$this->request->data = Hash::merge($this->request->data, $accessCounter);
			//--AccessCounterFrameSetting
			$this->request->data = Hash::merge(
				$this->request->data,
				$this->AccessCounterFrameSetting->getAccessCounterFrameSetting($this->viewVars['frameKey'], true)
			);
			//--Frame
			$this->request->data['Frame'] = array(
				'id' => $this->viewVars['frameId'],
				'key' => $this->viewVars['frameKey']
			);
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
				$this->redirect('/access_counters/access_counter_blocks/index/' . $this->viewVars['frameId']);
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
		if ($data['Block']['public_type'] === Block::TYPE_LIMITED) {
			//$data['Block']['from'] = implode('-', $data['Block']['from']);
			//$data['Block']['to'] = implode('-', $data['Block']['to']);
		} else {
			unset($data['Block']['from'], $data['Block']['to']);
		}

		if (isset($data['AccessCounterFrameSetting']['display_type'])) {
			$data['AccessCounterFrameSetting']['display_type'] = (int)$data['AccessCounterFrameSetting']['display_type'];
		}
		if (isset($data['AccessCounter']['count_start'])) {
			$data['AccessCounter']['count'] = (int)$data['AccessCounter']['count_start'];
		}

		return $data;
	}

}
