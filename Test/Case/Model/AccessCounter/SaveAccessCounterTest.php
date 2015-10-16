<?php
/**
 * AccessCounter::saveAccessCounter()のテスト
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
App::uses('NetCommonsSaveTest', 'NetCommons.TestSuite');

/**
 * AccessCounter::saveAccessCounter()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\AccessCounters\Test\Case\Model\AccessCounter
 */
class AccessCounterSaveAccessCounterTest extends NetCommonsSaveTest {

/**
 * Plugin name
 *
 * @var array
 */
	public $plugin = 'access_counters';

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
 * Model name
 *
 * @var array
 */
	protected $_modelName = 'AccessCounter';

/**
 * Method name
 *
 * @var array
 */
	protected $_methodName = 'saveAccessCounter';

/**
 * data
 *
 * @var array
 */
	private $__data = array(
		'Frame' => array(
			'id' => '6'
		),
		'Block' => array(
			'id' => '1',
			'key' => 'block_2',
			'language_id' => '2',
			'room_id' => '1',
			'plugin_key' => 'access_counters',
			'key' => 'block_2',
			'public_type' => '1',
		),
		'AccessCounter' => array(
			'id' => '1',
			'block_key' => 'block_2',
			'count' => '2',
			'count_start' => '0',
		),
		'AccessCounterFrameSetting' => array(
				'id' => 2,
				'frame_key' => 'frame_2',
				'display_type' => 2,
				'display_digit' => 5,
		),

	);

/**
 * SaveのDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *
 * @return void
 */
	public function dataProviderSave() {
		return array(
			array($this->__data),
		);
	}

/**
 * SaveのExceptionErrorのDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド
 *
 * @return void
 */
	public function dataProviderSaveOnExceptionError() {
		return array(
			array($this->__data, 'AccessCounters.AccessCounter', 'save'),
			array($this->__data, 'AccessCounters.AccessCounterFrameSetting', 'save'),
		);
	}

/**
 * SaveのValidationErrorのDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *
 * @return void
 */
	public function dataProviderSaveOnValidationError() {
		return array(
			array($this->__data, 'AccessCounters.AccessCounter'),
			array($this->__data, 'AccessCounters.AccessCounterFrameSetting'),
		);
	}

/**
 * ValidationErrorのDataProvider
 *
 * ### 戻り値
 *  - field フィールド名
 *  - value セットする値
 *  - message エラーメッセージ
 *  - overwrite 上書きするデータ
 *
 * @return void
 */
	public function dataProviderValidationError() {
		return array(
			array($this->__data, 'count', '-1',
				__d('net_commons', 'Invalid request.')),
			array($this->__data, 'count_start', '-1',
				__d('net_commons', 'Invalid request.')),
			array($this->__data, 'block_key', '',
				__d('net_commons', 'Invalid request.')),
		);
	}

}
