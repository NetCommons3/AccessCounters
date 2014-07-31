<?php
/**
 * AccessCountersFrame Test Case
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 * @since       NetCommons 3.0.0.0
 * @package     app.Plugin.AccessCounters.Test.Model.Case
 */

App::uses('AccessCountersFrame', 'AccessCounters.Model');

/**
 * AccessCountersFrame Test Case
 *
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since       NetCommons 3.0.0.0
 * @package     app.Plugin.AccessCounters.Test.Model.Case
 */
class AccessCountersFrameTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @var     array
 */
	public $fixtures = array(
		'plugin.access_counters.access_counters_language',
		'plugin.access_counters.access_counters_frame',
	);

/**
 * setUp method
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @return  void
 */
	public function setUp() {
		parent::setUp();
		$this->AccessCountersFrame = ClassRegistry::init('AccessCounters.AccessCountersFrame');
	}

/**
 * testIndex
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @return  void
 */
	public function testIndex() {
		$this->assertTrue(true);
	}

/**
 * testGetBlockId
 *
 * @return void
 */
	public function testGetBlockId() {
		$frameId = 1;
		$rtn = $this->AccessCountersFrame->getBlockId($frameId);
		$this->assertTextEquals($rtn, 1);
	}

/**
 * testGetBlockId no data
 *
 * @return void
 */
	public function testGetBlockIdNoData() {
		$frameId = 9999999999;
		$rtn = $this->AccessCountersFrame->getBlockId($frameId);
		$this->assertNull($rtn);
	}

/**
 * testGetBlockId null data
 *
 * @return void
 */
	public function testGetBlockIdNullData() {
		$frameId = null;
		$rtn = $this->AccessCountersFrame->getBlockId($frameId);
		$this->assertNull($rtn);
	}

/**
 * testGetBlockId char data
 *
 * @return void
 */
	public function testGetBlockIdCharData() {
		$frameId = 'test';
		$rtn = $this->AccessCountersFrame->getBlockId($frameId);
		$this->assertNull($rtn);
	}

/**
 * tearDown method
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @return  void
 */
	public function tearDown() {
		unset($this->AccessCountersFrame);

		parent::tearDown();
	}

}
