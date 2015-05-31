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

App::uses('YACakeTestCase', 'NetCommons.TestSuite');
App::uses('YAControllerTestCase', 'NetCommons.TestSuite');
App::uses('RolesControllerTest', 'Roles.Test/Case/Controller');
App::uses('AuthGeneralControllerTest', 'AuthGeneral.Test/Case/Controller');

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
class AccessCountersControllerTestBase extends ControllerTestCase {

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
		'plugin.net_commons.site_setting',
		'plugin.pages.languages_page',
		'plugin.pages.page',
		'plugin.pages.space',
		'plugin.plugin_manager.plugin',
		'plugin.roles.default_role_permission',
		'plugin.rooms.plugins_room',
		'plugin.rooms.roles_room',
		'plugin.rooms.roles_rooms_user',
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

		YACakeTestCase::loadTestPlugin($this, 'NetCommons', 'TestPlugin');

		$this->generate(
			'AccessCounters.AccessCounters',
			[
				'components' => [
					'Auth' => ['user'],
					'Session',
					'Security',
				]
			]
		);
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
}
