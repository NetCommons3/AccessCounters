<?php
/**
 * AccessCounters Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AccessCountersAppController', 'AccessCounters.Controller');

/**
 * AccessCounters Controller
 *
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package NetCommons\AccessCounters\Controller
 */
class AccessCountersController extends AccessCountersAppController {

/**
 * use model
 *
 * @var array
 */
	public $uses = array(
		'Frames.Frame',
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
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.Token'
	);

/**
 * index
 *
 * @return void
 */
	public function index() {
		$this->setAction('view');
	}

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

		//AccessCounter共通データ取得
		$this->initAccessCounter(['block']);

		//counterデータ取得
		if (! $accessCounter = $this->AccessCounter->getAccessCounter(
			$this->viewVars['blockKey'],
			$this->viewVars['roomId']
		)) {
			$accessCounter = $this->AccessCounter->create();
		}

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

		$accessCounter = $this->camelizeKeyRecursive($accessCounter);
		$this->set($accessCounter);
	}

/**
 * add
 *
 * @return void
 */
	public function add() {
		//レイアウトの設定
		$this->layout = 'NetCommons.setting';
		$results = $this->camelizeKeyRecursive($this->NetCommonsFrame->data);
		$this->set($results);
		$this->view = 'edit';

		//タブの設定
		$this->initTabs('block_index', 'block_settings');

		//AccessCounter共通データ取得
		$this->initAccessCounter();

		$this->set('blockId', null);
		$accessCounter = $this->AccessCounter->create(
			array(
				'id' => null,
				'block_key' => null,
			)
		);
		$block = $this->Block->create(
			array(
				'id' => null,
				'key' => null,
				'name' => __d('access_counters', 'New Counter %s', date('YmdHis')),
			)
		);

		$data = array();
		if ($this->request->isPost()) {
			$data = $this->__parseRequestData();

			$this->AccessCounter->saveAccessCounter($data);
			if ($this->handleValidationError($this->AccessCounter->validationErrors)) {
				if (! $this->request->is('ajax')) {
					$this->redirect('/access_counters/blocks/index/' . $this->viewVars['frameId']);
				}
				return;
			}

			$data['Block']['id'] = null;
			$data['Block']['key'] = null;
		}

		$results = $this->camelizeKeyRecursive(Hash::merge(
			$accessCounter, $block, $data
		));
		$this->set($results);
	}

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		if (! $this->NetCommonsBlock->validateBlockId()) {
			$this->throwBadRequest();
			return false;
		}
		$this->set('blockId', (int)$this->params['pass'][1]);

		//レイアウトの設定
		$this->layout = 'NetCommons.setting';
		$results = $this->camelizeKeyRecursive($this->NetCommonsFrame->data);
		$this->set($results);

		//タブの設定
		$this->initTabs('block_index', 'block_settings');

		//AccessCounter共通データ取得
		$this->initAccessCounter(['block']);

		//counterデータ取得
		if (! $accessCounter = $this->AccessCounter->getAccessCounter(
			$this->viewVars['blockKey'],
			$this->viewVars['roomId']
		)) {
			$this->throwBadRequest();
			return false;
		}

		$data = array();
		if ($this->request->isPost()) {
			$data = $this->__parseRequestData();

			$this->AccessCounter->saveAccessCounter($data);
			if ($this->handleValidationError($this->AccessCounter->validationErrors)) {
				if (! $this->request->is('ajax')) {
					$this->redirect('/access_counters/blocks/index/' . $this->viewVars['frameId']);
				}
				return;
			}
		}

		$results = $this->camelizeKeyRecursive(Hash::merge(
			$accessCounter, $data
		));
		$this->set($results);
	}

/**
 * delete
 *
 * @return void
 */
	public function delete() {
		if (! $this->NetCommonsBlock->validateBlockId()) {
			$this->throwBadRequest();
			return false;
		}
		$this->set('blockId', (int)$this->params['pass'][1]);

		$this->initAccessCounter(['block']);

		if ($this->request->isDelete()) {
			if ($this->AccessCounter->deleteAccessCounter($this->data)) {
				if (! $this->request->is('ajax')) {
					$this->redirect('/access_counters/blocks/index/' . $this->viewVars['frameId']);
				}
				return;
			}
		}

		$this->throwBadRequest();
	}

/**
 * Parse data from request
 *
 * @return array
 */
	private function __parseRequestData() {
		$data = $this->data;
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
