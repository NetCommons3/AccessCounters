<?php
/**
 * AccessCounter::getAccessCounter()のテスト
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
App::uses('NetCommonsGetTest', 'NetCommons.TestSuite');
//App::uses('AccessCounterTestBase', 'AccessCounters.Test/Case/Model/AccessCounter);

/**
 * AccessCounter::getAccessCounter()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\AccessCounters\Test\Case\Model\AccessCounter
 */
class AccessCounterGetAccessCounterTest extends NetCommonsGetTest {

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
	);

/**
 * AccessCounter::GetAccessCounterのテスト
 * $createdがtrue
 * @return void
 */
	public function testGetAccessCounterCreatedTrue() {
		//事前データセット
		$created = true;

		//期待値
		$expected = $this->AccessCounter->create();

		//テスト実施
		$result = $this->AccessCounter->getAccessCounter( $created );

		//チェック
		$this->assertEquals($result, $expected);
	}

/**
 * AccessCounter::GetAccessCounterのテスト
 * $createdがfalse
 * @return void
 */
	public function testGetAccessCounterCreatedFalse() {
		//事前データセット
		$created = false;

		//期待値
		$expected = array();

		//テスト実施
		$result = $this->AccessCounter->getAccessCounter( $created );

		//チェック
		$this->assertEquals($result, $expected);
	}

}
