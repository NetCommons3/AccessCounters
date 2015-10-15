<?php
/**
 * AccessCounter::getAccessCounterFrameSetting()のテスト
 *
 * @property AccessCounter $AccessCounter
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AccessCounters', 'AccessCounters.Model');
App::uses('AccessCounterFrameSetting', 'AccessCounters.Model');
App::uses('NetCommonsGetTest', 'NetCommons.TestSuite');

/**
 * AccessCounterFrameSetting::getAccessCounterFrameSetting()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\AccessCounters\Test\Case\Model\AccessCounter
 */
class AccessCounterFrameSettingGetAccessCounterFrameSettingTest extends NetCommonsGetTest {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.access_counters.access_counter',
		'plugin.access_counters.access_counter_frame_setting',
	);

/**
 * Getのテスト(GetAccessCounterTestと同じ)
 *
 * @param array 
 * @dataProvider dataProviderGet
 * @return void
 */
	public function testGet($created, $exist, $expected) {
		//事前準備
		$testCurrentData = Hash::expand($exist);
		Current::$current = Hash::merge(Current::$current, $testCurrentData);

		//テスト実行
		$result = $this->AccessCounterFrameSetting->getAccessCounterFrameSetting($created);
		if (empty($result)) {//Createしないとき
			$this->assertEquals($result, $expected);
		} else {
			foreach ($expected as $key => $val) {
				$this->assertEquals($result['AccessCounterFrameSetting'][$key], $val);
			}
		}
	}

/**
 * getのDataProvider
 *
 * ### 戻り値
 *  - bool  生成フラグ($created)
 *  - array 取得するキー情報
 *  - array 期待値 （取得したキー情報）
 *
 * @return array
 */
	public function dataProviderGet() {
		$existData = array('Frame.key' => 'frame_1'); // データあり
		$notExistData = array('Frame.key' => 'frame_xxx'); // データなし

		return array(
			array(true, $existData, array( 'id' => '1' )),
			array(false, $existData, array( 'id' => '1' )),
			array(true, $notExistData, array( 'frame_key' => 'frame_xxx' )),
			array(false, $notExistData, array()),
		);
	}

}
