<?php
/**
 * AccessCounter Test Case
 *
 * @property AccessCounter $AccessCounter
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AccessCounter', 'AccessCounters.Model');

/**
 * AccessCounter Test Case
 */
class AccessCounterTest extends CakeTestCase {

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
	);

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
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AccessCounter);

		parent::tearDown();
	}

/**
 * testGetDisplayTypeLabelExist method
 *
 * @return void
 */
	public function testGetDisplayTypeLabelExist() {
		$displayType = 2;
		$result = $this->AccessCounter->getDisplayTypeLabel($displayType);

		$expected = 'success';

		$this->assertEquals($expected, $result);
	}

/**
 * testGetDisplayTypeLabelNotExist method
 *
 * @return void
 */
	public function testGetDisplayTypeLabelNotExist() {
		$displayType = null;
		$result = $this->AccessCounter->getDisplayTypeLabel($displayType);

		$expected = 'default';

		$this->assertEquals($expected, $result);
	}

/**
 * testGetDisplayTypeOptions method
 *
 * @return void
 */
	public function testGetDisplayTypeOptions() {
		$result = $this->AccessCounter->getDisplayTypeOptions();

		$expected = array(
			'default',
			'primary',
			'success',
			'info',
			'warning',
			'danger',
		);

		$this->assertEquals($expected, $result);
	}

/**
 * testGetDisplayDigitOptions method
 *
 * @return void
 */
	public function testGetDisplayDigitOptions() {
		$result = $this->AccessCounter->getDisplayDigitOptions();

		$expected = array(
			3 => 3,
			4 => 4,
			5 => 5,
			6 => 6,
			7 => 7,
			8 => 8,
			9 => 9,
		);

		$this->assertEquals($expected, $result);
	}

/**
 * testGetCounterInfoExist method
 *
 * @return void
 */
	public function testGetCounterInfoExist() {
		$blockKey = 'block_1';
		$result = $this->AccessCounter->getCounterInfo($blockKey);

		$expected = array(
			'AccessCounter' => array(
				'id' => '1',
				'block_key' => 'block_1',
				'count' => '1',
				'starting_count' => '0',
				'is_started' => true,
			),
			'Block' => array(
				'id' => '1'
			),
			'Frame' => array(
				'id' => '1'
			),
			'AccessCounterFrameSetting' => array(
				'id' => '1',
				'frame_key' => 'frame_1',
				'display_type' => '1',
				'display_digit' => '3',
				'display_type_label' => 'primary'
			)
		);

		$this->assertEquals($expected, $result);
	}

/**
 * testGetCounterInfoNotExist method
 *
 * @return void
 */
	public function testGetCounterInfoNotExist() {
		$blockKey = null;
		$result = $this->AccessCounter->getCounterInfo($blockKey);

		$expected = array(
			'AccessCounter' => array(
				'starting_count' => 0,
				'is_started' => false,
			),
			'AccessCounterFrameSetting' => array(
				'id' => null,
				'display_type' => '0',
				'display_digit' => '3',
				'display_type_label' => 'default',
			)
		);

		$this->assertEquals($expected, $result);
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
				array('block_key' => 'aaa'),
				array('count' => '0'),
				array('count' => '1'),
				array('count' => '2147483647'),
				array('starting_count' => '0'),
				array('starting_count' => '1'),
				array('starting_count' => '999999999'),
			),
			// 異常系
			false => array(
				array('block_key' => null),
				array('block_key' => ''),
				array('count' => '-1'),
				array('count' => '2147483648'),
				array('count' => '+1'),
				array('count' => '1.1'),
				array('count' => '01'),
				array('starting_count' => '-1'),
				array('starting_count' => '1000000000'),
				array('starting_count' => '+1'),
				array('starting_count' => '1.1'),
				array('starting_count' => '01'),
			)
		);

		foreach ($testCases as $expected => $cases) {
			foreach ($cases as $case) {

				$this->AccessCounter->set($case);
				$result = $this->AccessCounter->validates();

				if ($expected) {
					$this->assertTrue($result, json_encode($case));
				} else {
					$this->assertFalse($result, json_encode($case));
				}

			}
		}
	}
}
