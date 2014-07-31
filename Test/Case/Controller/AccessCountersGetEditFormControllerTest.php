<?php
/**
 * AccessCountersGetEditFormController Test Case
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 * @since       NetCommons 3.0.0.0
 * @package     app.Plugin.AccessCounters.Test.Controller.Case
 */

App::uses('AccessCountersController', 'AccessCounters.Controller');

/**
 * AccessCountersGetEditFormController Test Case
 *
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since       NetCommons 3.0.0.0
 * @package     app.Plugin.AccessCounters.Test.Controller.Case
 */
class AccessCountersGetEditFormControllerTest extends ControllerTestCase {

/**
 * Controller name
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @var     string
 */
	public $name = 'AccessCountersControllerTest';

/**
 * Fixtures
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @var     array
 */
	public $fixtures = array(
		'app.Session',
		'app.SiteSetting',
		'app.SiteSettingValue',
		'app.Page',
		'plugin.users.user',
		'plugin.access_counters.access_counter',
		'plugin.access_counters.access_counters_language',
		'plugin.access_counters.access_counters_block',
		'plugin.access_counters.access_counters_frame',
		'plugin.access_counters.access_counters_format',
		'plugin.access_counters.access_counters_count',
	);

/**
 * httpXRequestedWith
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @var     array
 */
	public $httpXRequestedWith = null;

/**
 * setUp
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since    NetCommons 3.0.0.0
 * @return   void
 */
	public function setUp() {
		parent::setUp();

		//Ajaxを有効にする
		$this->httpXRequestedWith = isset($_SERVER['HTTP_X_REQUESTED_WITH']) ? $_SERVER['HTTP_X_REQUESTED_WITH'] : null;
		$_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
	}

/**
 * authUserCallback
 *
 * @param type $key
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since    NetCommons 3.0.0.0
 * @return   mixed
 */
	public function authUserCallback() {
		$auth = array(
			'id' => 1,
			'username' => 'admin',
		);
		return $auth;
	}

/**
 * tearDown method
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @return  void
 */
	public function tearDown() {
		//セッティングモードOFF
		Configure::write('Pages.isSetting', false);

		//Ajaxの設定を元に戻す。
		if (! isset($this->httpXRequestedWith)) {
			unset($_SERVER['HTTP_X_REQUESTED_WITH']);
		} else {
			$_SERVER['HTTP_X_REQUESTED_WITH'] = $this->httpXRequestedWith;
		}

		parent::tearDown();
	}

/**
 * get form edit
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since    NetCommons 3.0.0.0
 * @return   void
 */
	public function testGetEditForm() {
		//ログイン処理
		$this->Controller = $this->generate('AccessCounters.AccessCounters', array(
			'components' => array(
				'Auth' => array('user'),
				'Session',
				'Security',
				'RequestHandler',
			),
		));

		$this->Controller->Auth
			->staticExpects($this->any())
			->method('user')
			->will($this->returnCallback(array($this, 'authUserCallback')));

		$this->Controller->Auth->login(array(
				'username' => 'admin',
				'password' => 'admin',
			)
		);
		$this->assertTrue($this->Controller->Auth->loggedIn());

		$frameId = 1;
		$this->testAction('/access_counters/access_counters/get_edit_form/' . $frameId . '/', array('method' => 'get'));

		//ログアウト処理
		$this->Controller->Auth->logout();
		//$this->assertFalse($this->Controller->Auth->loggedIn());
	}

/**
 * get form edit no login
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since    NetCommons 3.0.0.0
 * @return   void
 */
	public function testGetEditFormNoLogin() {
		$frameId = 1;
		$this->testAction('/access_counters/access_counters/get_edit_form/' . $frameId . '/', array('method' => 'get'));
	}

}
