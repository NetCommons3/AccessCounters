<?php
/**
 * AccessCountersLoginController Test Case
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
 * AccessCountersLoginController Test Case
 *
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package     app.Plugin.AccessCounters.Test.Controller.Case
 * @SuppressWarnings(PHPMD.TooManyMethods)
 */
class AccessCountersLoginControllerTest extends ControllerTestCase {

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
		//セッティングモードOFF
		Configure::write('Pages.isSetting', false);

		//ログアウト処理
		$this->Controller->Auth->logout();

		$this->assertFalse($this->Controller->Auth->loggedIn());

		parent::tearDown();
	}

/**
 * assertAccessCountersLabel
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return   void
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 */
	public function assertAccessCountersLabel($statusId, $isSetting, $isPublish, $isEditor, $message = '') {
		//各ラベルのチェック
		$statuses = Configure::read('AccessCounters.Status');

		foreach ($statuses as $defStatusId) {
			if (! $isPublish && ! $isEditor) {
				continue;
			}

			if ($defStatusId == $statusId && ($isSetting || $statusId != Configure::read('AccessCounters.Status.Publish'))) {
				$correct = 'access-counters-status-' . $defStatusId;
				$this->assertContains($correct, $this->view, $correct, $message);
			} elseif ($isSetting) {
				$correct = 'access-counters-status-' . $defStatusId . ' hidden';
				$this->assertContains($correct, $this->view, $correct, $message);
			} else {
				$correct = 'access-counters-status-' . $defStatusId;
				$this->assertNotContains($correct, $this->view, $correct, $message);
			}
		}

		//プレビュー表示中
		if ($isSetting && ($isPublish || $isEditor)) {
			$correct = 'access-counters-preview hidden';
			$this->assertContains($correct, $this->view, $correct, $message);
		} else {
			$correct = 'access-counters-preview hidden';
			$this->assertNotContains($correct, $this->view, $correct, $message);
		}
	}

/**
 * assertAccessCountersLabel
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return   void
 */
	public function assertAccessCountersEditBtn($frameId, $isSetting, $isPublish, $isEditor, $message = '') {
		//ブロック設定ボタン
		if ($isSetting && $isPublish) {
			$correct = 'openBlockSetting(' . $frameId . ')';
			$this->assertContains($correct, $this->view, $correct, $message);
		} else {
			$correct = 'openBlockSetting(' . $frameId . ')';
			$this->assertNotContains($correct, $this->view, $correct, $message);
		}

		//編集ボタン
		if ($isSetting && $isEditor) {
			$correct = 'openBlockSetting(' . $frameId . ')';
			$this->assertContains($correct, $this->view, $correct, $message);
		} else {
			$correct = 'openBlockSetting(' . $frameId . ')';
			$this->assertNotContains($correct, $this->view, $correct, $message);
		}
	}

/**
 * index
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return   void
 */
	public function testIndex() {
		$frameId = 1;
		$this->testAction('/access_counters/access_counters/index/' . $frameId . '/', array('method' => 'get'));

		$this->assertTextNotContains('ERROR', $this->view);

		$correct = 'access-counters-content-view-' . $frameId;
		$this->assertContains($correct, $this->view, $correct);

		$correct = 'Prefix2 0000000002 Suffix2';
		$this->assertContains($correct, $this->view, $correct);

		$statusId = Configure::read('AccessCounters.Status.PublishRequest');
		$isSetting = false;
		$isPublish = true;
		$isEditor = true;

		//各ラベルのチェック
		$this->assertAccessCountersLabel($statusId, $isSetting, $isPublish, $isEditor);
		//上部ボタンのチェック
		$this->assertAccessCountersEditBtn($frameId, $isSetting, $isPublish, $isEditor);
	}

/**
 * index "no format"
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return   void
 */
	public function testIndexNoFormat() {
		$frameId = 10;
		$this->testAction('/access_counters/access_counters/index/' . $frameId . '/', array('method' => 'get'));

		$this->assertTextNotContains('ERROR', $this->view);
		$this->assertTextEquals('', trim($this->view));
	}

/**
 * index "no format" and "setting on"
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return   void
 */
	public function testIndexNoFormatIsSetting() {
		//セッティングモードON
		Configure::write('Pages.isSetting', true);

		$frameId = 10;
		$this->testAction('/access_counters/access_counters/index/' . $frameId . '/', array('method' => 'get'));

		$this->assertTextNotContains('ERROR', $this->view);

		$correct = 'access-counters-content-view-' . $frameId;
		$this->assertContains($correct, $this->view, $correct);

		$statusId = null;
		$isSetting = true;
		$isPublish = true;
		$isEditor = true;

		//各ラベルのチェック
		$this->assertAccessCountersLabel($statusId, $isSetting, $isPublish, $isEditor);
		//上部ボタンのチェック
		$this->assertAccessCountersEditBtn($frameId, $isSetting, $isPublish, $isEditor);
	}

/**
 * index status publish status_id test
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return   void
 */
	public function testIndexStatus() {
		$frameIds = array(
			'11' => array('Status' => 'Publish'),
			'12' => array('Status' => 'PublishRequest'),
			'13' => array('Status' => 'Draft'),
			'14' => array('Status' => 'Reject'),
		);

		foreach ($frameIds as $frameId => $data) {
			$this->setUp();
			$this->view = null;

			$this->testAction('/access_counters/access_counters/index/' . $frameId . '/', array('method' => 'get'));

			$this->assertTextNotContains('ERROR', $this->view);

			$correct = 'access-counters-content-view-' . $frameId;
			$this->assertContains($correct, $this->view, $correct, 'frameId=' . $frameId . "\ndata=" . print_r($data, true));

			if ($data['Status'] == 'Publish') {
				$correct = 'COUNTER 0000000001';
			} else {
				$correct = 'COUNTER 0000000000';
			}
			$this->assertContains($correct, $this->view, $correct, 'frameId=' . $frameId . "\ndata=" . print_r($data, true));

			$statusId = Configure::read('AccessCounters.Status.' . $data['Status']);
			$isSetting = false;
			$isPublish = true;
			$isEditor = true;

			//各ラベルのチェック
			$this->assertAccessCountersLabel($statusId, $isSetting, $isPublish, $isEditor, 'frameId=' . $frameId . "\ndata=" . print_r($data, true));
			//上部ボタンのチェック
			$this->assertAccessCountersEditBtn($frameId, $isSetting, $isPublish, $isEditor, 'frameId=' . $frameId . "\ndata=" . print_r($data, true));
		}
	}

/**
 * index status publish status_id test
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return   void
 */
	public function testIndexStatusSettingOn() {
		//セッティングモードON
		Configure::write('Pages.isSetting', true);

		$frameIds = array(
			11 => array('Status' => 'Publish'),
			12 => array('Status' => 'PublishRequest'),
			13 => array('Status' => 'Draft'),
			14 => array('Status' => 'Reject'),
		);

		foreach ($frameIds as $frameId => $data) {
			$this->setUp();
			$this->view = null;

			$this->testAction('/access_counters/access_counters/index/' . $frameId . '/', array('method' => 'get'));

			$this->assertTextNotContains('ERROR', $this->view, 'frameId=' . $frameId . "\ndata=" . print_r($data, true));

			$correct = 'access-counters-content-view-' . $frameId;
			$this->assertContains($correct, $this->view, $correct, 'frameId=' . $frameId . "\ndata=" . print_r($data, true));

			if ($data['Status'] == 'Publish') {
				$correct = 'COUNTER 0000000001';
			} else {
				$correct = 'COUNTER 0000000000';
			}
			$this->assertContains($correct, $this->view, $correct, 'frameId=' . $frameId . "\ndata=" . print_r($data, true));

			$statusId = Configure::read('AccessCounters.Status.' . $data['Status']);
			$isSetting = true;
			$isPublish = true;
			$isEditor = true;

			//各ラベルのチェック
			$this->assertAccessCountersLabel($statusId, $isSetting, $isPublish, $isEditor, 'frameId=' . $frameId . "\ndata=" . print_r($data, true));
			//上部ボタンのチェック
			$this->assertAccessCountersEditBtn($frameId, $isSetting, $isPublish, $isEditor, 'frameId=' . $frameId . "\ndata=" . print_r($data, true));
		}
	}
}
