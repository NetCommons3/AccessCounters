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
		'NetCommons.NetCommonsBlock', //use AccessCounter model or view
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsRoomRole' => array(
			//コンテンツの権限設定
			'allowedActions' => array(
				'contentEditable' => array('edit')
			),
		),
		'Security' => array('validatePost' => false),
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
 * index method
 *
 * @return void
 */
	public function index() {
		$this->view = 'AccessCounters/view';
		$this->view();
	}

/**
 * view method
 *
 * @return CakeResponse A response object containing the rendered view.
 */
	public function view() {
		$blockKey = $this->viewVars['blockKey'];
		$isAccessed = 'block_key_' . $blockKey;

		// blockKeyに紐づくカウンタ情報の取得
		$counter = $this->AccessCounter->getCounterInfo($blockKey);

		// カウント開始前
		if (!$counter['AccessCounter']['is_started']) {
			// アクセス情報をクリア
			$this->Session->delete($isAccessed);
		}

		// カウント開始済 && アクセス情報なし
		if ($counter['AccessCounter']['is_started'] &&
				$this->Session->read($isAccessed) === null) {

			// カウントアップ処理
			$counter['AccessCounter']['count']++;
			$AccessCounter = array(
				'id' => $counter['AccessCounter']['id'],
				'count' => $counter['AccessCounter']['count']
			);
			$this->AccessCounter->save($AccessCounter);

			// アクセス情報を記録
			$this->Session->write($isAccessed, CakeSession::read('Config.userAgent'));
		}

		$results = array(
			'counter' => $counter
		);
		$results = $this->camelizeKeyRecursive($results);
		$this->set($results);
		return $this->render('AccessCounters/view');
	}

/**
 * edit method
 *
 * @return CakeResponse A response object containing the rendered view.
 */
	public function edit() {
		$counter = $this->AccessCounter->getCounterInfo($this->viewVars['blockKey']);
		$results = array(
			'counter' => $counter
		);
		$results = $this->camelizeKeyRecursive($results);
		if ($this->request->isGet()) {
			CakeSession::write('backUrl', $this->request->referer());
		}

		$this->set($results);
		if ($this->request->isPost()) {
			$this->AccessCounterFrameSetting->saveSetting($this->data);
			if (!$this->handleValidationError($this->AccessCounter->validationErrors)) {
				return;
			}
			if (!$this->handleValidationError($this->AccessCounterFrameSetting->validationErrors)) {
				return;
			}
			$this->redirectByFrameId();
		}
	}
}
