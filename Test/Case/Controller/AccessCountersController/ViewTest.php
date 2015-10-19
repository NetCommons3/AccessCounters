<?php
/**
 * AccessCountersController Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AccessCountersController', 'AccessCounters.Controller');
App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * AccessCountersController Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\AccessCounters\Test\Case\Controller
 */
class AccessCountersControllerViewTest extends NetCommonsControllerTestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		if (! $this->_controller) {
			$this->_controller = Inflector::singularize($this->plugin) . '_' . 'blocks';
		}
		$this->generateNc(Inflector::camelize($this->_controller));
	}

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
 * Plugin name
 *
 * @var array
 */
	public $plugin = 'access_counters';

/**
 * Controller name
 *
 * @var string
 */
	protected $_controller = 'access_counters';

/**
 * テストDataの取得
 *
 * @return array
 */
	private function __getData() {
		$frameId = '6';
		$blockId = '1';
		$blockKey = 'block_2';
		$accesscounterId = '1';

		$data = array(
			'Frame' => array(
				'id' => $frameId
			),
			'Block' => array(
				'id' => $blockId,
				'key' => $blockKey,
				'language_id' => '2',
				'room_id' => '1',
				'plugin_key' => $this->plugin,
				'public_type' => '1',
			),
			'AccessCounter' => array(
				'id' => $accesscounterId,
				'block_key' => $blockKey,
				'count' => '2',
				'count_start' => '0',
			),
		);

		return $data;
	}

/**
 * viewアクションのGETテスト
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $sessionFlg セッション有無
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderView
 * @return void
 */
	public function testView($urlOptions, $assert, $sessionFlg = null, $exception = null, $return = 'view') {
		//セッション
		if ($sessionFlg !== null) {
			$this->controller->Session->expects($this->any())
			->method('read')
			->will($this->returnValue(true));
		}

		//Exception
		//if($exception) {
		//	$this->setExpectedException($exception);
		//		$Mock = $this->getMockForModel('AccessCounters.AccessCounter', array('updateAll'));
		//		$Mock->expects($this->once())
		//		->method('updateAll')
		//		->will($this->returnValue(false));
		//}

		//テスト実施
		$url = Hash::merge(array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'view',
		), $urlOptions);

		$this->_testGetAction($url, $assert, $exception, $return);
	}

/**
 * viewアクション用DataProvider
 *
 * #### 戻り値
 *  - urlOptions: URLオプション
 *  - assert: テストの期待値
 *  - session: セッション有無
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderView() {
		//$return = 'view';
		$results = array();

		// 正常
		$data1 = $this->__getData();

		$results[0] = array(
			'urlOptions' => array('frame_id' => $data1['Frame']['id'], 'block_id' => $data1['Block']['id'], 'key' => $data1['AccessCounter']['id']),
			'assert' => array('method' => 'assertNotEmpty')
		);

		//Block.idが取得できない
		$data2 = $this->__getData();

		$data2['Frame']['id'] = 16;
		$data2['Block']['id'] = 0;

		$results[1] = array(
			'urlOptions' => array('frame_id' => $data2['Frame']['id'], 'block_id' => $data2['Block']['id'], 'key' => $data2['AccessCounter']['id']),
			'assert' => array('method' => 'assertEmpty')
		);

		//Sessionあり
		$data3 = $this->__getData();
		$results[2] = array(
			'urlOptions' => array('frame_id' => $data3['Frame']['id'], 'block_id' => $data3['Block']['id'], 'key' => $data3['AccessCounter']['id']),
			'assert' => array('method' => 'assertNotEmpty'),
			'sessionFlg' => '1'
		);

		//Error
		//$data3 = $this->__getData();
		//$exception = 'InternalErrorException';
		//$results[2] = array(
		//	'urlOptions' => array('frame_id' => $data3['Frame']['id'], 'block_id' => $data3['Block']['id'], 'key' => $data3['AccessCounter']['id']),
		//	'assert' => array('method' => 'assertNotEmpty'),
		//	'sessionFlg' => '0',
		//	$exception,
		//);
		//PENDING （Exceptionの通し方が分からない）
		// ↑実行するとFになる。「1) AccessCountersControllerViewTest::testView with data set #2 (array('6', '1', '1'), array('assertNotEmpty'), '0', 'InternalErrorException')
		//Failed asserting that exception of type "PHPUnit_Framework_Error_Notice" matches expected exception "InternalErrorException". Message was: "Undefined index: id".

		return $results;
	}

}
