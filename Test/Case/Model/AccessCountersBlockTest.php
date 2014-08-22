<?php
/**
 * AccessCountersBlock Test Case
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 * @package     app.Plugin.AccessCounters.Test.Model.Case
 */

App::uses('AccessCountersBlock', 'AccessCounters.Model');

/**
 * AccessCountersBlock Test Case
 *
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package     app.Plugin.AccessCounters.Test.Model.Case
 */
class AccessCountersBlockTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @var     array
 */
	public $fixtures = array(
		'plugin.access_counters.access_counters_block',
	);

/**
 * setUp method
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return  void
 */
	public function setUp() {
		parent::setUp();
		$this->AccessCountersBlock = ClassRegistry::init('AccessCounters.AccessCountersBlock');
	}

/**
 * testIndex
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return  void
 */
	public function testIndex() {
		$this->assertTrue(true);
	}

/**
 * testSaveBlockId
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return  void
 */
	public function testSaveBlockId() {
		$dd['AccessCountersBlock']['id'] = 1;
		$dd['AccessCountersBlock']['room_id'] = 1;
		$dd['AccessCountersBlock']['create_user_id'] = 1;
		$mine = $this->AccessCountersBlock->save($dd);
		$this->assertTrue(is_numeric($mine['AccessCountersBlock']['id']));
	}

/**
 * tearDown method
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return  void
 */
	public function tearDown() {
		unset($this->AccessCountersBlock);

		parent::tearDown();
	}

}
