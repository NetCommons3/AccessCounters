<?php
/**
 * AccessCounterEditControllerNoLogin Test Case
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
 * AccessCounterEditControllerNoLoginTest Test Case
 *
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package NetCommons\AccessCounters\Test\Case\Controller
 */
class AccessCounterEditControllerNoLoginTest extends ControllerTestCase {

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
		'plugin.net_commons.site_setting',
		'plugin.access_counters.access_counter',
		'plugin.access_counters.access_counter_frame_setting',
		'plugin.access_counters.plugin',
		'plugin.blocks.block',
		'plugin.blocks.block_role_permission',
		'plugin.boxes.box',
		'plugin.frames.frame',
		'plugin.boxes.boxes_page',
		'plugin.containers.container',
		'plugin.containers.containers_page',
		'plugin.m17n.language',
		'plugin.m17n.languages_page',
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
 * testBeforeFilterByNoSetFrameId method
 *
 * @return void
 */
	public function testBeforeFilterByNoSetFrameId() {
		$this->setExpectedException('ForbiddenException');
		$this->testAction('/access_counters/access_counters/edit', array('method' => 'get'));
	}

/**
 * testBeforeFilterErrorByNoEditable method
 *
 * @return void
 */
	public function testBeforeFilterErrorByNoEditable() {
		$this->setExpectedException('ForbiddenException');
		$this->testAction('/access_counters/access_counters/edit/1', array('method' => 'get'));
	}
}
