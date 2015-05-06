<?php
/**
 * AccessCountersController Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AccessCountersController', 'AccessCounters.Controller');
App::uses('NetCommonsFrameComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsBlockComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsRoomRoleComponent', 'NetCommons.Controller/Component');

/**
 * AccessCountersController Test Case
 *
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package NetCommons\AccessCounters\Test\Case\Controller
 */
class AccessCountersControllerTest extends ControllerTestCase {

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
		'plugin.access_counters.access_counter',
		'plugin.access_counters.access_counter_frame_setting',
		'plugin.blocks.block',
		'plugin.blocks.block_role_permission',
		'plugin.boxes.box',
		'plugin.boxes.boxes_page',
		'plugin.containers.container',
		'plugin.containers.containers_page',
		'plugin.frames.frame',
		'plugin.m17n.language',
		'plugin.m17n.languages_page',
		'plugin.net_commons.plugin',
		'plugin.net_commons.site_setting',
		'plugin.pages.page',
		'plugin.pages.space',
		'plugin.roles.default_role_permission',
		'plugin.rooms.roles_rooms_user',
		'plugin.rooms.roles_room',
		'plugin.rooms.room',
		'plugin.rooms.room_role_permission',
		'plugin.users.user',
		'plugin.users.user_attributes_user',
	);

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		Configure::write('Config.language', 'ja');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		Configure::write('Config.language', null);
		parent::tearDown();
	}

/**
 * testBeforeFilterErrorByNoSetFrameId method
 *
 * @return void
 */
	public function testBeforeFilterErrorByNoSetFrameId() {
		//$this->setExpectedException('ForbiddenException');
		//$this->testAction('/access_counters/access_counters/index', array('method' => 'get'));
	}

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {
		$frameId = '161';
		$this->testAction('/access_counters/access_counters/index/' . $frameId,
			array(
				'method' => 'get',
				'return' => 'view',
			)
		);

		$expected = 'primary';
		$this->assertTextContains($expected, $this->view);
	}

/**
 * testIndex method
 *
 * @return void
 */
	public function testView() {
		$frameId = '161';
		$this->testAction('/access_counters/access_counters/view/' . $frameId,
			array(
				'method' => 'get',
				'return' => 'view',
			)
		);

		$expected = 'primary';
		$this->assertTextContains($expected, $this->view);
	}

/**
 * testViewNotStarted method
 *
 * @return void
 */
	public function testViewNotStarted() {
		$frameId = '162';
		$this->testAction('/access_counters/access_counters/view/' . $frameId,
			array(
				'method' => 'get',
				'return' => 'view',
			)
		);

		$expected = 'primary';
		$this->assertTextContains($expected, $this->view);
	}
}
