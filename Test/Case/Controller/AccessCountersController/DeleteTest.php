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
 * @package NetCommons\Faqs\Test\Case\Controller\AccessCountersController
 */
class AccessCountersControllerDeleteTest extends NetCommonsControllerTestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
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
 * deleteアクションのGETテスト
 *
 * @param string $role ロール
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderDeleteGet
 * @return void
 */
	public function testDeleteGet($role, $urlOptions, $assert, $exception = null, $return = 'view') {
		//ログイン
		if (isset($role)) {
			TestAuthGeneral::login($this, $role);
		}

		//テスト実施
		$url = Hash::merge(array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'delete',
		), $urlOptions);

		$this->_testGetAction($url, $assert, $exception, $return);

		//ログアウト
		if (isset($role)) {
			TestAuthGeneral::logout($this);
		}
	}

/**
 * deleteアクションのGETテスト用DataProvider
 *
 * #### 戻り値
 *  - role: ロール
 *  - urlOptions: URLオプション
 *  - assert: テストの期待値
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderDeleteGet() {
		$data = $this->__getData();
		$results = array();

		$results[0] = array('role' => null,
			'urlOptions' => array('frame_id' => $data['Frame']['id'], 'block_id' => $data['Block']['id'], 'key' => $data['AccessCounter']['id']),
			'assert' => null, 'exception' => 'ForbiddenException'
		);
		$results[1] = array('role' => null,
			'urlOptions' => array('frame_id' => $data['Frame']['id'], 'block_id' => $data['Block']['id'], 'key' => $data['AccessCounter']['id']),
			'assert' => null, 'exception' => 'ForbiddenException'
		);

		return $results;
	}

/**
 * deleteアクションのPOSTテスト
 *
 * @param array $data POSTデータ
 * @param string $role ロール
 * @param array $urlOptions URLオプション
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderDeletePost
 * @return void
 */
	public function testDeletePost($data, $role, $urlOptions, $exception = null, $return = 'view') {
		//ログイン
		if (isset($role)) {
			TestAuthGeneral::login($this, $role);
		}

		//テスト実施
		$this->_testPostAction('delete', $data, Hash::merge(array('action' => 'delete'), $urlOptions), $exception, $return);

		//正常の場合、リダイレクト
		if (! $exception) {
			$header = $this->controller->response->header();
			$this->assertNotEmpty($header['Location']);
		}

		//ログアウト
		if (isset($role)) {
			TestAuthGeneral::logout($this);
		}
	}

/**
 * deleteアクションのPOSTテスト用DataProvider
 *
 * #### 戻り値
 *  - data: 登録データ
 *  - role: ロール
 *  - urlOptions: URLオプション
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderDeletePost() {
		$data = $this->__getData();

		return array(
			//ログインなし
			array(
				'data' => $data, 'role' => null,
				'urlOptions' => array('frame_id' => $data['Frame']['id'], 'block_id' => $data['Block']['id'], 'key' => $data['AccessCounter']['id']),
				'exception' => 'ForbiddenException'
			),
			//ログインあり
			array(
				'data' => $data, 'role' => Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR,
				'urlOptions' => array('frame_id' => $data['Frame']['id'], 'block_id' => $data['Block']['id'], 'key' => $data['AccessCounter']['id']),
			),
		);
	}

/**
 * deleteアクションのExceptionErrorテスト
 *
 * @param string $mockModel Mockのモデル
 * @param string $mockMethod Mockのメソッド
 * @param array $data POSTデータ
 * @param array $urlOptions URLオプション
 * @param string $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderDeleteExceptionError
 * @return void
 */
	public function testDeleteExceptionError($mockModel, $mockMethod, $data, $urlOptions, $exception = null, $return = 'view') {
		list($mockPlugin, $mockModel) = pluginSplit($mockModel);
		$Mock = $this->getMockForModel($mockPlugin . '.' . $mockModel, array($mockMethod));
		$Mock->expects($this->once())
			->method($mockMethod)
			->will($this->returnValue(false));
		$this->testDeletePost($data, Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR, $urlOptions, $exception, $return);
	}

/**
 * deleteアクションのExceptionErrorテスト用DataProvider
 *
 * #### 戻り値
 *  - mockModel: Mockのモデル
 *  - mockMethod: Mockのメソッド
 *  - data: 登録データ
 *  - urlOptions: URLオプション
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderDeleteExceptionError() {
		$data = $this->__getData();

		return array(
			array(
				'mockModel' => 'AccessCounters.AccessCounter', 'mockMethod' => 'deleteAccessCounter', 'data' => $data,
				'urlOptions' => array('frame_id' => $data['Frame']['id'], 'block_id' => $data['Block']['id'], 'key' => $data['AccessCounter']['id']),
				'exception' => 'BadRequestException'
			),
			array(
				'mockModel' => 'AccessCounters.AccessCounter', 'mockMethod' => 'deleteAccessCounter', 'data' => $data,
				'urlOptions' => array('frame_id' => $data['Frame']['id'], 'block_id' => $data['Block']['id'], 'key' => $data['AccessCounter']['id']),
				'exception' => 'BadRequestException', 'return' => 'json'
			),
		);
	}

}
