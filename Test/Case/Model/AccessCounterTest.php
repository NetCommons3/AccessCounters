<?php
/**
 * AccessCounter Test Case
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 * @package     app.Plugin.AccessCounters.Test.Model.Case
 */

App::uses('AccessCounter', 'AccessCounters.Model');

/**
 * AccessCounter Test Case
 *
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package     app.Plugin.AccessCounters.Test.Model.Case
 */
class AccessCounterTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @var     array
 */
	public $fixtures = array(
		'plugin.access_counters.access_counter',
	);

/**
 * setUp method
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return  void
 */
	public function setUp() {
		parent::setUp();
		$this->AccessCounter = ClassRegistry::init('AccessCounters.AccessCounter');
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
 * tearDown method
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return  void
 */
	public function tearDown() {
		unset($this->AccessCounter);

		parent::tearDown();
	}

}
