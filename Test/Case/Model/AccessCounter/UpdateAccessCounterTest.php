<?php
/**
 * AccessCounter::UpdateCountUp AccessCounter()のテスト
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
App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * AccessCounter::UpdateAccessCounter()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\AccessCounters\Test\Case\Model\AccessCounter
 */
class AccessCounterUpdateAccessCounterTest extends NetCommonsModelTestCase {

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
	protected $_methodName = 'updateCountUp';

/**
 * data
 *
 * @var array
 */
	private $__data = array(
			'Block' => array(
				'id' => '2',
				'key' => 'block_2',
			),
			'AccessCounter' => array(
				'id' => '2',
				'block_key' => 'block_2'
			),
	);

/**
 * UpdateCountUpのテスト
 *
 * @param array 
 * @dataProvider dataProviderupdateCountUp
 * @return void
 */
	public function testupdateCountUp($data) {
		$model = $this->_modelName;

		//テスト実行前のチェック
		$accessCounterBef = $this->$model->find('first', array(
			'recursive' => -1,
			'conditions' => array('block_key' => $data[$this->$model->alias]['block_key']),
		));

		//テスト実行
		$result = $this->AccessCounter->updateCountUp($data);

		//チェック
		$accessCounterAft = $this->$model->find('first', array(
				'recursive' => -1,
				'conditions' => array('block_key' => $data[$this->$model->alias]['block_key']),
			));

		if ($result == true){//カウントアップ
			$this->assertEquals($accessCounterBef['AccessCounter']['count'] + 1, $accessCounterAft['AccessCounter']['count']);
		}
	}

/**
 * updateCountUpのDataProvider
 *
 * ### 戻り値
 *  - data 取得データ
 *
 * @return void
 */
	public function dataProviderupdateCountUp() {
		return array(
			array($this->__data),
		);
	}

/**
 * updateCountUpのExceptionErrorテスト
 *
 * @param array $data 登録データ
 * @param string $mockModel Mockのモデル
 * @param string $mockMethod Mockのメソッド
 * @dataProvider dataProviderSaveOnExceptionError
 * @return void
 */
	public function testupdateCountUpOnExceptionError($data, $mockModel, $mockMethod) {
		$model = $this->_modelName;
		$method = $this->_methodName;

		$this->_mockForReturnFalse($model, $mockModel, $mockMethod);

		$this->setExpectedException('InternalErrorException');
		$this->$model->$method($data);
	}

/**
 * updateCountUpのExceptionErrorのDataProvider
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
			array($this->__data, 'AccessCounters.AccessCounter', 'updateAll'),
		);
	}

}
