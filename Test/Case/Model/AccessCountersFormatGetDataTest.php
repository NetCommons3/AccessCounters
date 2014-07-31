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
class AccessCountersFormatGetDataTest extends CakeTestCase {

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
 * testGetPublishData
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @return  void
 */
	public function testGetPublishData() {
		$blockId = 1;
		$langId = 2;
		$mine = $this->AccessCountersFormat->getPublishData($blockId, $langId);
		$this->assertTrue(is_numeric($mine['AccessCountersFormat']['id']));
		$this->assertTextEquals(2, $mine['AccessCountersFormat']['id']);
		$this->assertTextEquals('Prefix1 ', $mine['AccessCountersFormat']['show_prefix_format']);
		$this->assertTextEquals(' Suffix1', $mine['AccessCountersFormat']['show_suffix_format']);
	}

/**
 * testGetPublishData error
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @return  void
 */
	public function testGetPublishDataError() {
		$datum = array(
			array('blockId' => 9999999999, 'langId' => 2),
			array('blockId' => null, 'langId' => 2),
			array('blockId' => 1, 'langId' => 9999999999),
			array('blockId' => 1, 'langId' => null),
		);

		foreach ($datum as $data) {
			$blockId = $data['blockId'];
			$langId = $data['langId'];

			$mine = $this->AccessCountersFormat->getPublishData($blockId, $langId);
			$this->assertTrue(empty($mine) && is_array($mine), print_r($data, true));
		}
	}

/**
 * testGetData no isSetting
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @return  void
 */
	public function testGetDataNoIsSetting() {
		$data = array(
			'blockId' => 1, 'langId' => 2
		);
		$blockId = $data['blockId'];
		$langId = $data['langId'];
		//$isSetting = true;

		$mine = $this->AccessCountersFormat->getData($blockId, $langId);

		$this->assertTrue(is_numeric($mine['AccessCountersFormat']['id']), print_r($data, true));
		$this->assertTextEquals(2, $mine['AccessCountersFormat']['id'], print_r($data, true));
		$this->assertTextEquals('Prefix1 ', $mine['AccessCountersFormat']['show_prefix_format'], print_r($data, true));
		$this->assertTextEquals(' Suffix1', $mine['AccessCountersFormat']['show_suffix_format'], print_r($data, true));

		$datum = array(
			array('blockId' => 1, 'langId' => 2, 'isSetting' => null),
			array('blockId' => 1, 'langId' => 2, 'isSetting' => false),
		);
		foreach ($datum as $data) {
			$blockId = $data['blockId'];
			$langId = $data['langId'];
			$isSetting = $data['isSetting'];

			$mine = $this->AccessCountersFormat->getData($blockId, $langId, $isSetting);

			$this->assertTrue(is_numeric($mine['AccessCountersFormat']['id']), print_r($data, true));
			$this->assertTextEquals(2, $mine['AccessCountersFormat']['id'], print_r($data, true));
			$this->assertTextEquals('Prefix1 ', $mine['AccessCountersFormat']['show_prefix_format'], print_r($data, true));
			$this->assertTextEquals(' Suffix1', $mine['AccessCountersFormat']['show_suffix_format'], print_r($data, true));
		}
	}

/**
 * testGetData isSetting
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @return  void
 */
	public function testGetDataIsSetting() {
		$isSetting = true;

		$blockId = 1;
		$langId = 2;
		$mine = $this->AccessCountersFormat->getData($blockId, $langId, $isSetting);
		$this->assertTrue(is_numeric($mine['AccessCountersFormat']['id']));
		$this->assertTextEquals(3, $mine['AccessCountersFormat']['id']);
		$this->assertTextEquals('Prefix2 ', $mine['AccessCountersFormat']['show_prefix_format']);
		$this->assertTextEquals(' Suffix2', $mine['AccessCountersFormat']['show_suffix_format']);
	}

/**
 * testGetData error
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @return  void
 */
	public function testGetDataError() {
		$datum = array(
			array('blockId' => null, 'langId' => null, 'isSetting' => false),
			array('blockId' => null, 'langId' => null, 'isSetting' => true),
			array('blockId' => null, 'langId' => null, 'isSetting' => null),

			array('blockId' => 9999999999, 'langId' => 9999999999, 'isSetting' => false),
			array('blockId' => 9999999999, 'langId' => 9999999999, 'isSetting' => true),
			array('blockId' => 9999999999, 'langId' => 9999999999, 'isSetting' => null),

			array('blockId' => 9999999999, 'langId' => 2, 'isSetting' => false),
			array('blockId' => 9999999999, 'langId' => 2, 'isSetting' => true),
			array('blockId' => 9999999999, 'langId' => 2, 'isSetting' => null),

			array('blockId' => null, 'langId' => 2, 'isSetting' => false),
			array('blockId' => null, 'langId' => 2, 'isSetting' => true),
			array('blockId' => null, 'langId' => 2, 'isSetting' => null),

			array('blockId' => 1, 'langId' => 9999999999, 'isSetting' => false),
			array('blockId' => 1, 'langId' => 9999999999, 'isSetting' => true),
			array('blockId' => 1, 'langId' => 9999999999, 'isSetting' => null),

			array('blockId' => 1, 'langId' => null, 'isSetting' => false),
			array('blockId' => 1, 'langId' => null, 'isSetting' => true),
			array('blockId' => 1, 'langId' => null, 'isSetting' => null),
		);
		foreach ($datum as $data) {
			$blockId = $data['blockId'];
			$langId = $data['langId'];
			$isSetting = $data['isSetting'];

			$mine = $this->AccessCountersFormat->getData($blockId, $langId, $isSetting);

			$this->assertTrue(empty($mine) && is_array($mine), print_r($data, true));
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
		//unset($this->AccessCounter);
		unset($this->AccessCountersFormat);

		parent::tearDown();
	}

}
