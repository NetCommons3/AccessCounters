<?php
/**
 * AccessCountersApp Controller
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 * @since       NetCommons 3.0.0.0
 * @package     app.Plugin.AccessCounters.Controller
 */

App::uses('AppController', 'Controller');

/**
 * AccessCountersApp Controller
 *
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since       NetCommons 3.0.0.0
 * @package     app.Plugin.AccessCounters.Controller
 */
class AccessCountersAppController extends AppController {

/**
 * setting mode
 *
 * @author    Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since     NetCommons 3.0.0.0
 * @var       bool
 */
	public $isSetting = false;

/**
 * Judgment result of asynchronous
 *
 * @author    Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since     NetCommons 3.0.0.0
 * @var       bool
 */
	public $isAjax = false;

/**
 * Edit authority
 *
 * @author    Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since     NetCommons 3.0.0.0
 * @var       bool
 */
	public $isEditor = false;

/**
 * Publish authority
 *
 * @author    Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since     NetCommons 3.0.0.0
 * @var       bool
 */
	public $isPublisher = false;

/**
 * Login
 *
 * @author    Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since     NetCommons 3.0.0.0
 * @var       bool
 */
	public $isLogin = false;

/**
 * Language ID
 *
 * @author    Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since     NetCommons 3.0.0.0
 * @var       int
 */
	public $langId = 2;

/**
 * Lang parameter
 *
 * @author    Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since     NetCommons 3.0.0.0
 * @var       string
 */
	public $lang = 'jpn';

/**
 * Languages list
 *
 * @author    Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since     NetCommons 3.0.0.0
 * @var       array
 */
	public $langList = array();

/**
 * userId
 *
 * @author    Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since     NetCommons 3.0.0.0
 * @var       bool
 */
	protected $_userId = null;

/**
 * roomId
 *
 * @author    Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since     NetCommons 3.0.0.0
 * @var       bool
 */
	protected $_roomId = null;

/**
 * Component name
 *
 * @author    Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since     NetCommons 3.0.0.0
 * @var       array
 */
	public $components = array(
		'DebugKit.Toolbar',
		'Session',
		'Asset',
		'Auth' => array(
			'loginAction' => array(
				'plugin' => 'auth',
				'controller' => 'auth',
				'action' => 'login',
			),
			'loginRedirect' => array(
				'plugin' => 'pages',
				'controller' => 'pages',
				'action' => 'index',
			),
			'logoutRedirect' => array(
				'plugin' => 'auth',
				'controller' => 'auth',
				'action' => 'login',
			)
		),
		'RequestHandler',
		'Security'
	);

/**
 * Check the editor, to set
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since    NetCommons 3.0.0.0
 * @return   bool
 */
	protected function _checkEditor() {
		//TODO本来パートから取得する（現状、管理者固定）
		if (! $this->isLogin) {
			$this->isEditor = false;
		} else {
			$this->isEditor = true;
		}
		$this->set('isEdit', $this->isEditor);
		return $this->isEditor;
	}

/**
 * Check the publisher, to set
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since    NetCommons 3.0.0.0
 * @return   void
 */
	protected function _checkPublisher() {
		//TODO本来パートから取得する（現状、管理者固定）
		if (! $this->isLogin) {
			$this->isPublisher = false;
		} else {
			$this->isPublisher = true;
		}
		$this->set('isPublisher', $this->isPublisher);
		return $this->isPublisher;
	}

/**
 * Check the author, to set
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since    NetCommons 3.0.0.0
 * @return   void
 */
	protected function _checkAuthor() {
		$this->set('isAuthor', true);
	}

/**
 * No asynchronous process if the layout settings.
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since    NetCommons 3.0.0.0
 * @return   void
 */
	protected function _setLayout() {
		if ($this->isAjax) {
			$this->layout = false;
		}
	}

/**
 * processing asynchronous
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since    NetCommons 3.0.0.0
 * @return   void
 */
	protected function _checkAjax() {
		if ($this->request->is('ajax')) {
			$this->isAjax = 1;
		}
	}

/**
 * Language settings
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since    NetCommons 3.0.0.0
 * @return   void
 */
	protected function _setLang() {
		//TODO言語は本来はDBより取得
		$this->langList = array(
			1 => 'eng',
			2 => 'jpn'
		);
		$this->lang = 'jpn';
		$this->langId = 2;
		$this->set('langId', $this->langId);
	}

/**
 * room_id setting
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since    NetCommons 3.0.0.0
 * @return   void
 */
	protected function _setRoomtId() {
		//TODOpageから取得するべき情報
		$this->_roomId = 1;
	}

/**
 * user_id setting
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since    NetCommons 3.0.0.0
 * @return   void
 */
	protected function _setUserId() {
		//TODOユーザIDは管理者固定
		$this->isLogin = $this->Auth->loggedIn();
		if ($this->isLogin) {
			$this->_userId = 1;
		} else {
			$this->_userId = 0;
		}
		$this->set('isLogin', $this->isLogin);
	}

/**
 * SettingMode settings
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since    NetCommons 3.0.0.0
 * @return   void
 */
	protected function _setSetting() {
		$this->isSetting = Configure::read('Pages.isSetting');
		$this->set('isSetting', $this->isSetting);
	}

/**
 * save error
 *
 * @param string $type response status type
 *     ERROR: Security Error! Unauthorized input.
 *     NG: Failed to register.
 *     OK: Success to register.
 * @param string $message response message
 * @param array $data response data
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since    NetCommons 3.0.0.0
 * @return   CakeResponse
 */
	protected function _setSaveResult($type, $message, $data = array()) {
		$result = array(
			'status' => $type,
			'message' => $message
		);
		if ($data) {
			$result['data'] = $data;
		}

		$this->set(compact('result'));
		$this->set('_serialize', 'result');

		return $this->render();
	}
}
