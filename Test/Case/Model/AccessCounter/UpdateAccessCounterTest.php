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
	public function testupdateCountUp($data, $expected) {
		$model = $this->_modelName;
		$method = $this->_methodName;

		$CounterBef = $this->$model->find('first', array(
			'recursive' => -1,
			'conditions' => $data
		));

		//テスト実行
		$result = $this->$model->$method($CounterBef);

		//チェック
		$CounterAft = $this->$model->find('first', array(
			'recursive' => -1,
			'conditions' => $data
		));

		$CounterAft = Hash::flatten($CounterAft);

		$this->assertTrue($result);

		foreach ($expected as $key => $val) {
			$this->assertEquals($val, $CounterAft[$key]);
		}
	}

/**
 * updateCountUpのDataProvider
 *
 * #### 戻り値
 *  - data 取得データ
 *
 * @return array
 */
	public function dataProviderupdateCountUp() {
		$data1 = array('AccessCounter.id' => '2');
		$expected1 = array('AccessCounter.count' => 101);

		return array(
			array( $data1, $expected1),
		);
	}

/**
 * updateCountUpのExceptionErrorテスト
 * （☆お知らせ事項）NetCommonsSaveTestを継承してExceptionError関数を使おうかと思いましたが、
 *                 dataProvidexxxValidation does not Existになりましたので、 ここにコピーして実装しています。
 * @param array $data 登録データ
 * @param string $mockModel Mockのモデル
 * @param string $mockMethod Mockのメソッド
 * @dataProvider dataProviderupdateCountUpOnExceptionError
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
 * #### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド
 *
 * @return array
 */

	public function dataProviderupdateCountUpOnExceptionError() {
		return array(
			array($this->__data, 'AccessCounters.AccessCounter', 'updateAll'),
		);
	}

}
