<?php
/**
 * AccessCounters Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @author Kazunori Sakamoto <exkazuu@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AccessCountersAppController', 'AccessCounters.Controller');

/**
 * AccessCounters Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @author Kazunori Sakamoto <exkazuu@gmail.com>
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
			'allow' => array(
				'add,edit,delete' => 'block_editable',
			),
		),
	);

/**
 * use models
 *
 * @var array
 */
	public $uses = array(
		'Blocks.Block',
		'Blocks.BlocksLanguage',
	);

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'Blocks.BlockForm',
		'Blocks.BlockTabs' => array(
			'mainTabs' => array('block_index', 'frame_settings'),
			'blockTabs' => array(
				'block_settings' => array('url' => array('controller' => 'access_counters'))
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
			if (! $this->request->is('ajax')) {
				$this->autoRender = false;
				return;
			}

			// AccessCounterデータ取得
			$accessCounter = $this->AccessCounter->getAccessCounter(false);
		} else {
			// AccessCounterデータ取得
			$accessCounter = $this->AccessCounter->getAccessCounter(true);

			// カウントアップ処理
			$isAccessed = 'block_key_' . Current::read('Block.key');
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
		}

		if ($this->request->is('ajax')) {
			$this->response->header('Pragma', 'no-cache');
			$this->set('_serialize', ['counterText']);
		}

		// AccessCounterFrameSettingデータ取得
		$counterFrameSetting = $this->AccessCounterFrameSetting->getAccessCounterFrameSetting(true);
		$this->set('accessCounterFrameSetting', $counterFrameSetting['AccessCounterFrameSetting']);

		$type = $counterFrameSetting['AccessCounterFrameSetting']['display_type'];
		$this->set('displayType', AccessCounterFrameSetting::$displayTypes[$type]);

		$format = '%0' . (int)$counterFrameSetting['AccessCounterFrameSetting']['display_digit'] . 'd';
		$this->set('counterText', sprintf($format, $accessCounter['AccessCounter']['count']));
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
		Current::write('Block', $this->Block->create()['Block']);
		Current::write('BlocksLanguage', $this->BlocksLanguage->create()['BlocksLanguage']);

		if ($this->request->is('post')) {
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
					'BlocksLanguage' => array(
						'language_id' => Current::read('Language.id'),
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

		if ($this->request->is('put')) {
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
			$this->request->data['Block'] = Current::read('Block');
			$this->request->data['BlocksLanguage'] = Current::read('BlocksLanguage');
			if (! $this->request->data['Block']['key']) {
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
		if ($this->request->is('delete')) {
			if ($this->AccessCounter->deleteAccessCounter($this->data)) {
				$this->redirect(NetCommonsUrl::backToIndexUrl('default_setting_action'));
				return;
			}
		}
		$this->throwBadRequest();
	}
}
