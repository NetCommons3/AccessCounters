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
class AccessCountersFormatTest extends CakeTestCase {

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
 * testGetDefaultData
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @return  void
 */
	public function testGetDefaultData() {
		$blockId = 1;
		$langId = 2;
		$mine = $this->AccessCountersFormat->getDefaultData($blockId, $langId);
		$this->assertTrue(isset($mine['AccessCountersFormat']));
		$this->assertTextEquals(10, count($mine['AccessCountersFormat']));
	}

/**
 * testGetDefaultDigitNumberData
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @return  void
 */
	public function testGetDefaultDigitNumberData() {
		$mine = $this->AccessCountersFormat->getDefaultDigitNumberData();
		$this->assertTrue(is_array($mine));
		$this->assertTextEquals(10, count($mine));
	}

/**
 * testGetDefaultDigitNumberData
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @return  void
 */
	public function testGetDefaultNumberImageData() {
		$mine = $this->AccessCountersFormat->getDefaultNumberImageData();

		$this->assertTrue(is_array($mine), $mine);
		$this->assertTextEquals(25, count($mine));

		$imgPath = APP . DS . 'Plugin' . DS . 'AccessCounters' . DS . WEBROOT_DIR . DS . 'img';
		foreach ($mine as $i => $img) {
			if ($i == 0) {
				continue;
			}
			for ($i = 0; $i < 10; $i++) {
				$this->assertFileExists($imgPath . DS . $img . DS . $i . '.gif');
			}
		}
	}

/**
 * testGetIsPublished
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @return  void
 */
	public function testGetIsPublished() {
		$blockId = 1;
		$langId = 2;
		$mine = $this->AccessCountersFormat->getIsPublished($blockId, $langId);
		$this->assertTrue($mine === true);
	}

/**
 * testGetIsPublished no publish
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @return  void
 */
	public function testGetIsPublishedNoPublish() {
		$blockId = 2;
		$langId = 2;
		$mine = $this->AccessCountersFormat->getIsPublished($blockId, $langId);
		$this->assertTrue($mine === false);
	}

/**
 * testGetIsPublished error
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @return  void
 */
	public function testGetIsPublishedError() {
		$data = array(
			array('blockId' => 999999999, 'langId' => 2),
			array('blockId' => null, 'langId' => 2),
			array('blockId' => 1, 'langId' => 999999999),
			array('blockId' => 1, 'langId' => null),
		);

		foreach ($data as $datum) {
			$blockId = $datum['blockId'];
			$langId = $datum['langId'];

			$mine = $this->AccessCountersFormat->getIsPublished($blockId, $langId);
			$this->assertTrue($mine === false, print_r($datum, true));
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
