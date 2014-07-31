<?php
/**
 * AccessCountersController Test Case
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
 * AccessCountersController Test Case
 *
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since       NetCommons 3.0.0.0
 * @package     app.Plugin.AccessCounters.Test.Controller.Case
 */
class AccessCountersControllerTest extends ControllerTestCase {

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
 * setUp
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since    NetCommons 3.0.0.0
 * @return   void
 */
	public function setUp() {
		parent::setUp();
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

		parent::tearDown();
	}

/**
 * index
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since    NetCommons 3.0.0.0
 * @return   void
 */
	public function testIndex() {
		$frameId = 1;
		$this->testAction('/access_counters/access_counters/index/' . $frameId . '/', array('method' => 'get'));

		$this->assertTextNotContains('ERROR', $this->view);

		$correct = 'access-counters-content-view-' . $frameId;
		$this->assertContains($correct, $this->view, $correct);

		$correct = 'Prefix1 0000000002 Suffix1';
		$this->assertContains($correct, $this->view, $correct);
	}

/**
 * index no frameId
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since    NetCommons 3.0.0.0
 * @return   void
 */
	public function testIndexNoFrameId() {
		$this->testAction('/access_counters/access_counters/index', array('method' => 'get'));

		$this->assertTextNotContains('ERROR', $this->view);
		$this->assertTextEquals('', trim($this->view));
	}

/**
 * index no blockId
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since    NetCommons 3.0.0.0
 * @return   void
 */
	public function testIndexNoBlockId() {
		$frameId = 3;
		$this->testAction('/access_counters/access_counters/index/' . $frameId . '/', array('method' => 'get'));

		$this->assertTextNotContains('ERROR', $this->view);
		$this->assertTextEquals('', trim($this->view));
	}

/**
 * index "setting on" and "no login"
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since    NetCommons 3.0.0.0
 * @return   void
 */
	public function testIndexNoLoginSettingOn() {
		Configure::write('Pages.isSetting', true);

		//フレームID、ブロックIDあり
		$frameId = 1;
		$this->testAction('/access_counters/access_counters/index/' . $frameId . '/', array('method' => 'get'));

		$this->assertTextNotContains('ERROR', $this->view);

		$correct = 'access-counters-content-view-' . $frameId;
		$this->assertContains($correct, $this->view, $correct);

		$correct = 'Prefix1 0000000002 Suffix1';
		$this->assertContains($correct, $this->view, $correct);
	}

/**
 * index "setting on" and "no login" and "no blockId"
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since    NetCommons 3.0.0.0
 * @return   void
 */
	public function testIndexNoLoginSettingOnNoBlockId() {
		Configure::write('Pages.isSetting', true);

		//ブロックIDなし
		$frameId = 3;
		$this->testAction('/access_counters/access_counters/index/' . $frameId . '/', array('method' => 'get'));

		$this->assertTextNotContains('ERROR', $this->view);
		$this->assertTextEquals('', trim($this->view));
	}

/**
 * index no publish
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since    NetCommons 3.0.0.0
 * @return   void
 */
	public function testIndexNoPlubish() {
		$frameId = 12;
		$this->testAction('/access_counters/access_counters/index/' . $frameId . '/', array('method' => 'get'));

		$this->assertTextNotContains('ERROR', $this->view);
		$this->assertTextEquals('', trim($this->view));
	}

}
