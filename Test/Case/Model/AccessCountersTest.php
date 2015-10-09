<?php
/**
 * AccessCounters Model Test Case
 *
 * @property AccessCounters $AccessCounters
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AccessCounters', 'AccessCounters.Model');
App::uses('AccessCountersModelTestBase', 'AccessCounters.Test/Case/Model');

/**
 * AccessCounters Model Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\AccessCounters\Test\Case\Model
 */
class AccessCountersTest extends AccessCountersModelTestBase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AccessCounter = ClassRegistry::init('AccessCounters.AccessCounter');
	}

/**
 * test method
 *
 * @return void
 */
	public function testGetAccessCounter() {
		// Run Test1
		$this->assertTrue(true);
	}
}
