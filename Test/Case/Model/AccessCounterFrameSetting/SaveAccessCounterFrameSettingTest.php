<?php
/**
 * AccessCounterFrameSetting::saveAccessCounterFrameSetting()のテスト
 *
 * @property AccessCounter $AccessCounter
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsSaveTest', 'NetCommons.TestSuite');

/**
 * AccessCounterFrameSetting::saveAccessCounterFrameSetting()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\AccessCounters\Test\Case\Model\AccessCounter
 */
class AccessCounterFrameSettingSaveAccessCounterFrameSettingTest extends NetCommonsSaveTest {

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
	protected $_modelName = 'AccessCounterFrameSetting';

/**
 * Method name
 *
 * @var array
 */
	protected $_methodName = 'saveAccessCounterFrameSetting';

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
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		$model = $this->_modelName;
		$this->$model = ClassRegistry::init(Inflector::camelize($this->plugin) . '.' . $model);
		parent::setUp();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		$model = $this->_modelName;
		unset($this->$model);
		parent::tearDown();
	}

/**
 * SaveのDataProvider
 *
 * #### 戻り値
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
 * #### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド
 *
 * @return array
 */
	public function dataProviderSaveOnExceptionError() {
		return array(
			array($this->__data, 'AccessCounters.AccessCounterFrameSetting', 'save'),
		);
	}

/**
 * SaveのValidationErrorのDataProvider
 *
 * #### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *
 * @return array
 */
	public function dataProviderSaveOnValidationError() {
		return array(
			array($this->__data, 'AccessCounters.AccessCounterFrameSetting'),
		);
	}

}
