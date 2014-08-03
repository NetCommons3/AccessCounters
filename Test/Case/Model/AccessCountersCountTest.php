<?php
/**
 * AccessCountersCount Test Case
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 * @since       NetCommons 3.0.0.0
 * @package     app.Plugin.AccessCounters.Test.Model.Case
 */

App::uses('AccessCountersCount', 'AccessCounters.Model');
App::uses('AccessCounter', 'AccessCounters.Model');

/**
 * AccessCountersCount Test Case
 *
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since       NetCommons 3.0.0.0
 * @package     app.Plugin.AccessCounters.Test.Model.Case
 * @SuppressWarnings(PHPMD.TooManyMethods)
 */
class AccessCountersCountTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @var     array
 */
	public $fixtures = array(
		'plugin.access_counters.access_counter',
		'plugin.access_counters.access_counters_language',
		'plugin.access_counters.access_counters_count',
		'plugin.access_counters.access_counters_block',
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
		$this->AccessCountersCount = ClassRegistry::init('AccessCounters.AccessCountersCount');
		$this->AccessCounter = ClassRegistry::init('AccessCounters.AccessCounter');
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
 * testGetDataId
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @return  void
 */
	public function testGetDataId() {
		$blockId = 1;
		$langId = 2;
		$mine = $this->AccessCountersCount->getAccessCount($blockId, $langId);
		$this->assertTrue(is_numeric($mine) && $mine > 0);
	}

/**
 * testGetDataId irregular test
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @return  void
 */
	public function testGetDataIdIrregular() {
		$datum = array(
			array('blockId' => 999999999, 'langId' => 1),
			array('blockId' => 999999999, 'langId' => 2),
			array('blockId' => 1, 'langId' => 999999999),
		);

		foreach ($datum as $data) {
			$blockId = $data['blockId'];
			$langId = $data['langId'];

			$mine = $this->AccessCountersCount->getAccessCount($blockId, $langId);
			$this->assertTrue(is_numeric($mine) && $mine == 0, print_r($data, true));
		}
	}

/**
 * testSaveCount
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @return  void
 */
	public function testSaveCount() {
		$blockId = 1;
		$langId = 2;
		$userId = 1;
		$mine = $this->AccessCountersCount->saveCountUp($blockId, $langId, $userId);
		$this->assertTrue(is_numeric($mine['AccessCountersCount']['id']));
		$this->assertTextEquals($blockId, $mine['AccessCountersCount']['block_id']);
		$this->assertTextEquals(2, $mine['AccessCountersCount']['access_count']);
	}

/**
 * testSaveCount no access_counters_count data
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @return  void
 */
	public function testSaveCountNoAccessCountersCountData() {
		$blockId = 10;
		$langId = 2;
		$userId = 1;
		$mine = $this->AccessCountersCount->saveCountUp($blockId, $langId, $userId);
		$this->assertTrue(is_numeric($mine['AccessCountersCount']['id']));
		$this->assertTextEquals($blockId, $mine['AccessCountersCount']['block_id']);
		$this->assertTextEquals(1, $mine['AccessCountersCount']['access_count']);
	}

/**
 * testSaveCount no userId
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @return  void
 */
	public function testSaveCountNoUserId() {
		$datum = array(
			array('blockId' => 1, 'langId' => 2, 'userId' => 0),
			array('blockId' => 1, 'langId' => 2, 'userId' => null),
		);

		$count = 2;
		foreach ($datum as $data) {
			$blockId = $data['blockId'];
			$langId = $data['langId'];
			$userId = $data['userId'];

			$mine = $this->AccessCountersCount->saveCountUp($blockId, $langId, $userId);

			$this->assertTrue(is_numeric($mine['AccessCountersCount']['id']), print_r($data, true));
			$this->assertTextEquals($blockId, $mine['AccessCountersCount']['block_id'], print_r($data, true));
			$this->assertTextEquals($count, $mine['AccessCountersCount']['access_count'], print_r($data, true));

			$count++;
		}
	}

/**
 * testSaveCount no blocks data
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @return  void
 */
	public function testSaveCountError() {
		$datum = array(
			array('blockId' => 999999999, 'langId' => 2, 'userId' => 1),
			array('blockId' => null, 'langId' => 2, 'userId' => null),
			array('blockId' => 1, 'langId' => null, 'userId' => 1),
		);
		foreach ($datum as $data) {
			$blockId = $data['blockId'];
			$langId = $data['langId'];
			$userId = $data['userId'];

			$mine = $this->AccessCountersCount->saveCountUp($blockId, $langId, $userId);
			$this->assertNull($mine, print_r($data, true));
		}
	}

/**
 * testSaveCount no langId
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @return  void
 */
	public function testSaveCountIrregular() {
		$datum = array(
			array('blockId' => 1, 'langId' => 999999999, 'userId' => 1),
		);
		foreach ($datum as $data) {
			$blockId = $data['blockId'];
			$langId = $data['langId'];
			$userId = $data['userId'];

			$mine = $this->AccessCountersCount->saveCountUp($blockId, $langId, $userId);

			$this->assertTrue(is_numeric($mine['AccessCountersCount']['id']), print_r($data, true));
			$this->assertTextEquals($blockId, $mine['AccessCountersCount']['block_id'], print_r($data, true));
			$this->assertTextEquals(1, $mine['AccessCountersCount']['access_count'], print_r($data, true));
		}
	}

/**
 * tearDown method
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @return  void
 */
	public function tearDown() {
		unset($this->AccessCountersCount);
		unset($this->AccessCounter);

		parent::tearDown();
	}

}
