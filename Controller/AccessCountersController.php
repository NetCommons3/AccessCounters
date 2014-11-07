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
	);

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsBlock', //use AccessCounter model or view
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsRoomRole',
	);

/**
 * beforeFilter
 *
 * @return void
 * @throws ForbiddenException
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();

		$frameId = (isset($this->params['pass'][0]) ? (int)$this->params['pass'][0] : 0);
		//Frameのデータをviewにセット
		if (! $this->NetCommonsFrame->setView($this, $frameId)) {
			throw new ForbiddenException('NetCommonsFrame');
		}
		//Roleのデータをviewにセット
		if (! $this->NetCommonsRoomRole->setView($this)) {
			throw new ForbiddenException('NetCommonsFrame');
		}
	}

/**
 * index method
 *
 * @param int $frameId frames.id
 * @return CakeResponse A response object containing the rendered view.
 */
	public function index($frameId = 0) {
		return $this->view($frameId);
	}

/**
 * index method
 *
 * @param int $frameId frames.id
 * @return CakeResponse A response object containing the rendered view.
 */
	public function view($frameId = 0) {
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

			// アクセス情報を記録w
			$this->Session->write($isAccessed, CakeSession::read('Config.userAgent'));
		}

		$this->set('counter', $counter);
		return $this->render('AccessCounters/view');
	}
}
