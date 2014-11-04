<?php
/**
 * AccessCounterFrameSetting Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AccessCounterFrameSetting', 'AccessCounters.Model');

/**
 * AccessCounterFrameSetting Test Case
 */
class AccessCounterFrameSettingTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.access_counters.access_counter',
		'plugin.access_counters.block',
		'plugin.access_counters.frame',
		'plugin.access_counters.access_counter_frame_setting',
		'plugin.access_counters.plugin',
		'plugin.frames.box',
		'plugin.frames.language',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$models = array(
			'Frame' => 'Frames.Frame',
			'Block' => 'Blocks.Block',
			'AccessCounter' => 'AccessCounters.AccessCounter',
			'AccessCounterFrameSetting' => 'AccessCounters.AccessCounterFrameSetting',
		);
		foreach ($models as $model => $class) {
			$this->$model = ClassRegistry::init($class);
		}
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();
	}

/**
 * testSaveSettingCreate method
 *
 * @return void
 */
	public function testSaveSettingCreate() {
		$postData = array(
			'AccessCounter' => array(
				'starting_count' => 0,
				'is_started' => 'false',
			),
			'AccessCounterFrameSetting' => array(
				'id' => 0,
				'display_digit' => 5,
				'display_type' => 3,
			),
			'Frame' => array(
				'id' => 2,
			)
		);

		$result = $this->AccessCounterFrameSetting->saveSetting($postData);

		$this->assertInternalType('string', $result);

		$isEmpty = empty($result);
		$expected = false;
		$this->assertEquals($expected, $isEmpty);
	}

/**
 * testSaveSettingUpdate method
 *
 * @return void
 */
	public function testSaveSettingUpdate() {
		$postData = array(
			'AccessCounter' => array(
				'is_started' => 'true',
			),
			'AccessCounterFrameSetting' => array(
				'id' => 1,
				'display_digit' => 5,
				'display_type' => 3,
			),
			'Frame' => array(
				'id' => 1,
			)
		);

		$result = $this->AccessCounterFrameSetting->saveSetting($postData);

		$expected = 'block_1';
		$this->assertEquals($expected, $result);
	}

/**
 * testSaveSettingErrorBySaveBlcok method
 *
 * @return void
 */
	public function testSaveSettingErrorBySaveBlcok() {
		$this->Block = $this->getMockForModel('Blocks.Block', array('save'));
		$this->Block->expects($this->any())
			->method('save')
			->will($this->returnValue(false));

		$postData = array(
			'Frame' => array(
				'id' => 2,
			)
		);

		$result = $this->AccessCounterFrameSetting->saveSetting($postData);
		$this->assertFalse($result);
	}

/**
 * testSaveSettingErrorBySaveFrame method
 *
 * @return void
 */
	public function testSaveSettingErrorBySaveFrame() {
		$this->Frame = $this->getMockForModel('Frames.Frame', array('save'));
		$this->Frame->expects($this->any())
			->method('save')
			->will($this->returnValue(false));

		$postData = array(
			'Frame' => array(
				'id' => 2,
			)
		);

		$result = $this->AccessCounterFrameSetting->saveSetting($postData);
		$this->assertFalse($result);

		unset($this->Frame);
	}

/**
 * testSaveSettingErrorBySaveCounter method
 *
 * @return void
 */
	public function testSaveSettingErrorBySaveCounter() {
		$postData = array(
			'AccessCounter' => array(
				'starting_count' => null, // Error Value
				'is_started' => 'false',
			),
			'AccessCounterFrameSetting' => array(
				'id' => 0,
				'display_digit' => 3,
				'display_type' => 0,
			),
			'Frame' => array(
				'id' => 2,
			)
		);

		$result = $this->AccessCounterFrameSetting->saveSetting($postData);

		$this->assertFalse($result);
	}

/**
 * testSaveSettingErrorBySaveSetting method
 *
 * @return void
 */
	public function testSaveSettingErrorBySaveSetting() {
		$postData = array(
			'AccessCounter' => array(
				'starting_count' => 0,
				'is_started' => 'false',
			),
			'AccessCounterFrameSetting' => array(
				'id' => 0,
				'display_digit' => null, // Error Value
				'display_type' => 0,
			),
			'Frame' => array(
				'id' => 2,
			)
		);

		$result = $this->AccessCounterFrameSetting->saveSetting($postData);

		$this->assertFalse($result);
	}

/**
 * testValidate method
 *
 * @return void
 */
	public function testValidate() {
		$testCases = array(
			// 正常系
			true => array(
				array('frame_key' => 'aaa'),
				array('display_type' => '0'),
				array('display_type' => '5'),
				array('display_digit' => '3'),
				array('display_digit' => '9'),
			),
			// 異常系
			false => array(
				array('frame_key' => null),
				array('frame_key' => ''),
				array('display_type' => '-1'),
				array('display_type' => '6'),
				array('display_type' => '1.1'),
				array('display_type' => '+1'),
				array('display_type' => '00'),
				array('display_type' => '01'),
				array('display_digit' => '2'),
				array('display_digit' => '10'),
				array('display_digit' => '1.1'),
				array('display_digit' => '+1'),
				array('display_digit' => '03'),
			)
		);

		foreach ($testCases as $expected => $cases) {
			foreach ($cases as $case) {

				$this->AccessCounterFrameSetting->set($case);
				$result = $this->AccessCounterFrameSetting->validates();

				if ($expected) {
					$this->assertTrue($result, json_encode($case));
				} else {
					$this->assertFalse($result, json_encode($case));
				}

			}
		}
	}
}