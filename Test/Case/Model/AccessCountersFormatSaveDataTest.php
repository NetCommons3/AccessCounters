<?php
/**
 * AccessCountersFormat Test Case
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 * @since       NetCommons 3.0.0.0
 * @package     app.Plugin.AccessCounters.Test.Model.Case
 */

App::uses('AccessCountersFormat', 'AccessCounters.Model');

/**
 * AccessCountersFormat Test Case
 *
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since       NetCommons 3.0.0.0
 * @package     app.Plugin.AccessCounters.Test.Model.Case
 */
class AccessCountersFormatSaveDataTest extends CakeTestCase {

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
		'plugin.access_counters.access_counters_block',
		'plugin.access_counters.access_counters_frame',
		'plugin.access_counters.access_counters_format',
		'plugin.access_counters.access_counters_count',
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
		//$this->AccessCounter = ClassRegistry::init('AccessCounters.AccessCounter');
		$this->AccessCountersFormat = ClassRegistry::init('AccessCounters.AccessCountersFormat');
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
 * testSaveData "no frameId" or "no userId" or "no roomId"
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @return  void
 */
	public function testSaveDataError() {
		$data = array(
			array('frameId' => 999999999, 'userId' => 1, 'roomId' => 1),
			//array('frameId' => 999999999, 'userId' => 999999999, 'roomId' => 1),
			array('frameId' => 999999999, 'userId' => null, 'roomId' => 1),
			//array('frameId' => 999999999, 'userId' => 1, 'roomId' => 999999999),
			array('frameId' => 999999999, 'userId' => 1, 'roomId' => null),
			//array('frameId' => 999999999, 'userId' => 999999999, 'roomId' => 999999999),
			array('frameId' => 999999999, 'userId' => 999999999, 'roomId' => null),
			array('frameId' => 999999999, 'userId' => null, 'roomId' => 999999999),
			array('frameId' => 999999999, 'userId' => null, 'roomId' => null),

			array('frameId' => null, 'userId' => 1, 'roomId' => 1),
			array('frameId' => null, 'userId' => 999999999, 'roomId' => 1),
			array('frameId' => null, 'userId' => null, 'roomId' => 1),
			array('frameId' => null, 'userId' => 1, 'roomId' => null),
			array('frameId' => null, 'userId' => 1, 'roomId' => 999999999),
			//array('frameId' => null, 'userId' => 999999999, 'roomId' => 999999999),
			array('frameId' => null, 'userId' => 999999999, 'roomId' => null),
			array('frameId' => null, 'userId' => null, 'roomId' => 999999999),
			array('frameId' => null, 'userId' => null, 'roomId' => null),

			//array('frameId' => 1, 'userId' => 999999999, 'roomId' => 1),
			array('frameId' => 1, 'userId' => null, 'roomId' => 1),
			//array('frameId' => 1, 'userId' => 1, 'roomId' => 999999999),
			array('frameId' => 1, 'userId' => 1, 'roomId' => null),
			//array('frameId' => 1, 'userId' => 999999999, 'roomId' => 999999999),
			array('frameId' => 1, 'userId' => 999999999, 'roomId' => null),
			array('frameId' => 1, 'userId' => null, 'roomId' => 999999999),
			array('frameId' => 1, 'userId' => null, 'roomId' => null),
		);
		foreach ($data as $datum) {
			$frameId = $datum['frameId'];
			$userId = $datum['userId'];
			$roomId = $datum['roomId'];

			$inputData['AccessCountersFormat']['block_id'] = 1;
			$inputData['AccessCountersFormat']['frame_id'] = $frameId;
			$inputData['AccessCountersFormat']['language_id'] = 2;
			$inputData['AccessCountersFormat']['show_digit_number'] = 5;
			$inputData['AccessCountersFormat']['show_number_image'] = 'color';
			$inputData['AccessCountersFormat']['show_prefix_format'] = 'SavePrefix';
			$inputData['AccessCountersFormat']['show_suffix_format'] = 'SaveSuffix';
			$inputData['AccessCountersFormat']['status'] = 'Publish';

			$mine = $this->AccessCountersFormat->saveData($inputData, $frameId, $userId, $roomId);
			$this->assertNull($mine, "inputData\n" . print_r($inputData, true) . "checkData\n" . print_r($datum, true));
		}
	}

/**
 * testSaveData
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @return  void
 */
	public function testSaveData() {
		$frameId = 1;
		$userId = 1;
		$roomId = 1;
		$langId = 2;
		$blockId = 1;

		$this->__saveData($frameId, $userId, $roomId, $langId, $blockId);
	}

/**
 * testSaveData no access counter data
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @return  void
 */
	public function testSaveDataNoAccessCounter() {
		$frameId = 3;
		$userId = 1;
		$roomId = 1;
		$langId = 2;
		$blockId = 3;

		$this->__saveData($frameId, $userId, $roomId, $langId, $blockId);
	}

/**
 * save data
 *
 * @param int $frameId frames.id
 * @param int $userId users.id
 * @param int $roomId rooms.id
 * @param int $langId languages.id
 * @param int $blockId blocks.id
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @return  void
 */
	private function __saveData($frameId, $userId, $roomId, $langId, $blockId) {
		$data['AccessCountersFormat']['block_id'] = $blockId;
		$data['AccessCountersFormat']['frame_id'] = $frameId;
		$data['AccessCountersFormat']['language_id'] = $langId;
		$data['AccessCountersFormat']['show_digit_number'] = 5;
		$data['AccessCountersFormat']['show_number_image'] = 'color';
		$data['AccessCountersFormat']['show_prefix_format'] = 'SavePrefix';
		$data['AccessCountersFormat']['show_suffix_format'] = 'SaveSuffix';
		$data['AccessCountersFormat']['status'] = 'Publish';

		$mine = $this->AccessCountersFormat->saveData($data, $frameId, $userId, $roomId);

		$this->assertTrue(is_numeric($mine['AccessCountersFormat']['id']) && $mine['AccessCountersFormat']['id'] > 1, print_r($data, true));
		$this->assertTextEquals('SavePrefix{X-NUMBER-IMAGE}SaveSuffix', $mine['AccessCountersFormat']['show_format'], print_r($data, true));
		$this->assertTextEquals(5, $mine['AccessCountersFormat']['show_digit_number'], print_r($data, true));
		$this->assertTextEquals('color', $mine['AccessCountersFormat']['show_number_image'], print_r($data, true));
		$this->assertTextEquals(1, $mine['AccessCountersFormat']['status_id'], print_r($data, true));
	}

/**
 * tearDown method
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @return  void
 */
	public function tearDown() {
		//unset($this->AccessCounter);
		unset($this->AccessCountersFormat);

		parent::tearDown();
	}

}
