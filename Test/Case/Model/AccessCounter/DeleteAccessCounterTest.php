<?php
/**
 * AccessCounter::deleteAccessCounter()のテスト
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
App::uses('NetCommonsDeleteTest', 'NetCommons.TestSuite');

/**
 * AccessCounter::deleteAccessCounter()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\AccessCounters\Test\Case\Model\AccessCounter
 */
class AccessCounterDeleteAccessCounterTest extends NetCommonsDeleteTest {

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
	protected $_methodName = 'deleteAccessCounter';

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
 * Deleteのテスト(AccessCounter)
 *
 * @param array $data 削除データ
 * @param array $associationModels 削除確認の関連モデル array(model => conditions)
 * @dataProvider dataProviderDelete
 * @return void
 */
	public function testDelete($data, $associationModels = null) {
		$model = $this->_modelName;
		$method = $this->_methodName;

		//テスト実行前のチェック
		$count = $this->$model->find('count', array(
			'recursive' => -1,
			'conditions' => array('block_key' => $data[$this->$model->alias]['block_key']),
		));
		$this->assertNotEquals(0, $count);

		//テスト実行
		$result = $this->$model->$method($data);
		$this->assertTrue($result);

		//チェック
		$count = $this->$model->find('count', array(
			'recursive' => -1,
			'conditions' => array('block_key' => $data[$this->$model->alias]['block_key']),
		));
		$this->assertEquals(0, $count);
	}

/**
 * DeleteのDataProvider
 *
 * #### 戻り値
 *  - data: 削除データ
 *  - associationModels: 削除確認の関連モデル array(model => conditions)
 *
 * @return void
 */
	public function dataProviderDelete() {
		return array(
			array($this->__data )
		);
	}

/**
 * ExceptionErrorのDataProvider
 *
 * #### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド
 *
 * @return void
 */
	public function dataProviderDeleteOnExceptionError() {
		return array(
			array($this->__data, 'AccessCounters.AccessCounter', 'deleteAll'),
		);
	}

}
