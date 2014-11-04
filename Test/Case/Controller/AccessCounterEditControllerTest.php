<?php
/**
 * AnnouncementEditController Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AccessCountersController', 'AccessCounters.Controller');
App::uses('NetCommonsFrameComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsBlockComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsRoomRoleComponent', 'NetCommons.Controller/Component');

/**
 * AccessCounterEditControllerTest Test Case
 *
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package NetCommons\AccessCounters\Test\Case\Controller
 */
class AccessCounterEditControllerTest extends ControllerTestCase {

/**
 * mock controller object
 *
 * @var Controller
 */
	public $Controller = null;

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'site_setting',
		'plugin.access_counters.access_counter',
		'plugin.access_counters.block',
		'plugin.access_counters.frame',
		'plugin.access_counters.access_counter_frame_setting',
		'plugin.access_counters.plugin',
		'plugin.frames.box',
		'plugin.frames.language',
		'plugin.rooms.room',
		'plugin.rooms.roles_rooms_user',
		'plugin.roles.default_role_permission',
		'plugin.rooms.roles_room',
		'plugin.rooms.room_role_permission',
		'plugin.rooms.user',
	);

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		Configure::write('Config.language', 'ja');
		$this->login();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		$this->logout();
		Configure::write('Config.language', null);
		parent::tearDown();
	}

/**
 * login　method
 *
 * @return void
 */
	public function login() {
		// AccessCounterEditControllerのモック生成
		$this->Controller = $this->generate('AccessCounters.AccessCounterEdit', array(
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

		//ログイン処理
		$this->Controller->Auth->login(array(
				'username' => 'admin',
				'password' => 'admin',
				'role_key' => 'system_administrator',
			)
		);
		$this->assertTrue($this->Controller->Auth->loggedIn(), 'login');
	}

/**
 * logout method
 *
 * @return void
 */
	public function logout() {
		//ログアウト処理
		$this->Controller->Auth->logout();
		$this->assertFalse($this->Controller->Auth->loggedIn(), 'logout');

		CakeSession::write('Auth.User', null);
		unset($this->Controller);
	}

/**
 * authUserCallback method
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return array user
 */
	public function authUserCallback() {
		$user = array(
			'id' => 1,
			'username' => 'admin',
			'role_key' => 'system_administrator',
		);
		CakeSession::write('Auth.User', $user);
		return $user;
	}

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {
		$this->testAction('/AccessCounters/AccessCounterEdit/index/1', array('method' => 'get'));

		$this->assertTextContains('display_type', $this->view);
		$this->assertTextContains('display_digit', $this->view);
		$this->assertTextContains('starting_count', $this->view);
	}

/**
 * testView method
 *
 * @return void
 */
	public function testView() {
		$this->testAction('/AccessCounters/AccessCounterEdit/view/1', array('method' => 'get'));

		$this->assertTextContains('display_type', $this->view);
		$this->assertTextContains('display_digit', $this->view);
		$this->assertTextContains('starting_count', $this->view);
	}

/**
 * testForm method
 *
 * @return void
 */
	public function testForm() {
		$this->testAction('/AccessCounters/AccessCounterEdit/form/1', array('method' => 'get'));

		$this->assertTextContains('display_type', $this->view);
		$this->assertTextContains('display_digit', $this->view);
		$this->assertTextContains('starting_count', $this->view);
	}

/**
 * testEdit method
 *
 * @return void
 */
	public function testEdit() {
		$postData = array(
			'AccessCounter' => array(
				'block_key' => 'block_1',
				'starting_count' => 0,
				'is_started' => 'true',
			),
			'AccessCounterFrameSetting' => array(
				'id' => 1,
				'display_digit' => 5,
				'display_type' => 3,
			),
			'Frame' => array(
				'id' => 1,
			)
		);

		$this->testAction('/AccessCounters/AccessCounterEdit/edit/1.json',
			array(
				'method' => 'post',
				'data' => $postData
			)
		);

		$this->assertEquals('result', $this->vars['_serialize']);

		$result = array_shift($this->vars['result']);
		$this->assertEquals(__d('net_commons', 'Successfully finished.'), $result);
	}

/**
 * testEditErrorByRequestGet method
 *
 * @return void
 */
	public function testEditErrorByRequestGet() {
		$this->setExpectedException('MethodNotAllowedException');
		$this->testAction('/AccessCounters/AccessCounterEdit/edit/1', array('method' => 'get'));
	}

/**
 * testEditErrorBySaveSetting method
 *
 * @return void
 */
	public function testEditErrorBySaveSetting() {
		$postData = array(
			'AccessCounter' => array(
				'block_key' => '',
				'starting_count' => 0,
				'is_started' => 'false',
			),
			'AccessCounterFrameSetting' => array(
				'id' => 0,
				'display_digit' => null, // Error
				'display_type' => 0,
			),
			'Frame' => array(
				'id' => '2',
			)
		);

		$this->setExpectedException('ForbiddenException');
		$this->testAction('/AccessCounters/AccessCounterEdit/edit/1.json',
			array(
				'method' => 'post',
				'data' => $postData
			)
		);
	}
}
