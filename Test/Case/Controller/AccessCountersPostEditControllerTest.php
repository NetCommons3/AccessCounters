<?php
/**
 * AccessCountersPostEditController Test Case
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 * @package     app.Plugin.AccessCounters.Test.Controller.Case
 */

App::uses('AccessCountersController', 'AccessCounters.Controller');

/**
 * AccessCountersPostEditController Test Case
 *
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package     app.Plugin.AccessCounters.Test.Controller.Case
 */
class AccessCountersPostEditControllerTest extends ControllerTestCase {

/**
 * Controller name
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @var     string
 */
	public $name = 'AccessCountersControllerTest';

/**
 * Fixtures
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
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
 * @var     array
 */
	public $httpXRequestedWith = null;

/**
 * setUp
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return   void
 */
	public function setUp() {
		parent::setUp();

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

		//Ajaxを有効にする
		$this->httpXRequestedWith = isset($_SERVER['HTTP_X_REQUESTED_WITH']) ? $_SERVER['HTTP_X_REQUESTED_WITH'] : null;
		$_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
	}

/**
 * authUserCallback
 *
 * @param type $key
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
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
 * @return  void
 */
	public function tearDown() {
		//Ajaxの設定を元に戻す。
		if (! isset($this->httpXRequestedWith)) {
			unset($_SERVER['HTTP_X_REQUESTED_WITH']);
		} else {
			$_SERVER['HTTP_X_REQUESTED_WITH'] = $this->httpXRequestedWith;
		}

		//ログアウト処理
		$this->Controller->Auth->logout();
		//$this->assertFalse($this->Controller->Auth->loggedIn());

		//セッティングモードOFF
		Configure::write('Pages.isSetting', false);

		parent::tearDown();
	}

/**
 * post edit
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return   void
 */
	public function testPostEdit() {
		$frameId = 1;
		$blockId = 1;
		$langId = 2;

		$data = array();
		$data['AccessCountersFormat']['frame_id'] = $frameId;
		$data['AccessCountersFormat']['block_id'] = $blockId;
		$data['AccessCountersFormat']['status'] = 'Draft';
		$data['AccessCountersFormat']['language_id'] = $langId;
		$data['AccessCountersFormat']['id'] = 0;
		$data['AccessCountersFormat']['show_number_image'] = 'color';
		$data['AccessCountersFormat']['show_digit_number'] = 5;
		$data['AccessCountersFormat']['show_prefix_format'] = 'PrefixEdit';
		$data['AccessCountersFormat']['show_suffix_format'] = ' SuffixEdit';

		$this->testAction('/access_counters/access_counters/edit/' . $frameId . '/',
			array(
				'method' => 'post',
				'data' => $data
			)
		);

		$this->assertTextNotContains('ERROR', $this->view);
	}

/**
 * post edit "GET"
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return   void
 */
	public function testPostEditMethodError() {
		$datum = array(
			array('frameId' => 1, 'blockId' => 1, 'langId' => 2, 'method' => 'get'),
			array('frameId' => 1, 'blockId' => 1, 'langId' => 2, 'method' => 'put'),
			array('frameId' => 1, 'blockId' => 1, 'langId' => 2, 'method' => 'delete'),
			array('frameId' => 1, 'blockId' => 1, 'langId' => 2, 'method' => 'aaaaaa'),
		);

		foreach ($datum as $data) {
			$this->view = null;
			$this->setUp();

			$frameId = $data['frameId'];
			$blockId = $data['blockId'];
			$langId = $data['langId'];
			$method = $data['method'];

			$inputData = array();
			$inputData['AccessCountersFormat']['frame_id'] = $frameId;
			$inputData['AccessCountersFormat']['block_id'] = $blockId;
			$inputData['AccessCountersFormat']['status'] = 'Draft';
			$inputData['AccessCountersFormat']['language_id'] = $langId;
			$inputData['AccessCountersFormat']['id'] = 0;
			$inputData['AccessCountersFormat']['show_number_image'] = 'color';
			$inputData['AccessCountersFormat']['show_digit_number'] = 5;
			$inputData['AccessCountersFormat']['show_prefix_format'] = 'PrefixEdit';
			$inputData['AccessCountersFormat']['show_suffix_format'] = ' SuffixEdit';

			$this->testAction('/access_counters/access_counters/edit/' . $frameId . '/',
				array(
					'method' => $method,
					'data' => $inputData
				)
			);

			$this->assertTextNotContains('ERROR', $this->view, print_r($data, true));

			$this->tearDown();
		}
	}

/**
 * post edit "GET"
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return   void
 */
	public function testPostEditSaveError() {
		$datum = array(
			array('frameId' => null, 'blockId' => 1, 'langId' => 2),
		);

		foreach ($datum as $data) {
			$this->view = null;
			$this->setUp();

			$frameId = $data['frameId'];
			$blockId = $data['blockId'];
			$langId = $data['langId'];

			$inputData = array();
			$inputData['AccessCountersFormat']['frame_id'] = $frameId;
			$inputData['AccessCountersFormat']['block_id'] = $blockId;
			$inputData['AccessCountersFormat']['status'] = 'Draft';
			$inputData['AccessCountersFormat']['language_id'] = $langId;
			$inputData['AccessCountersFormat']['id'] = 0;
			$inputData['AccessCountersFormat']['show_number_image'] = 'color';
			$inputData['AccessCountersFormat']['show_digit_number'] = 5;
			$inputData['AccessCountersFormat']['show_prefix_format'] = 'PrefixEdit';
			$inputData['AccessCountersFormat']['show_suffix_format'] = ' SuffixEdit';

			$this->testAction('/access_counters/access_counters/edit/' . $frameId . '/',
				array(
					'method' => 'post',
					'data' => $inputData
				)
			);

			$this->assertTextNotContains('ERROR', $this->view, 'data=' . print_r($data, true) . "\ninputData=" . print_r($inputData, true));

			$this->tearDown();
		}
	}

}
