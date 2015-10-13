<?php
/**
 * AccessCounterテストの共通クラス
 *
 * @property AccessCounter $AccessCounter
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AccessCountersModelTestBase', 'AccessCounters.Test/Case/Model');

/**
 * Announcementテストの共通クラス
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Announcements\Test\Case\Model\AccessCounter
 */
class AccessCounterTestBase extends AccessCountersModelTestBase {
/**
 * setUp
 *
 * @return void
 */

	public function setUp() {
		parent::setUp();
		$this->AccessCounter = ClassRegistry::init('AccessCounters.AccessCounter');
		$this->AccessCounterFrameSetting = ClassRegistry::init('AccessCounters.AccessCounterFrameSetting');
		$this->Block = ClassRegistry::init('Blocks.Block');
		$this->Frame = ClassRegistry::init('Frames.Frame');
	}

/**
 * tearDown
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AccessCounter);
		unset($this->AccessCounterFrameSetting);
		unset($this->Block);
		unset($this->Frame);
		parent::tearDown();
	}

/**
 * data
 *
 * @var array
 */
	public $data = array(
		'Frame' => array(
			'id' => '6'
		),
		'Block' => array(
			'id' => '2',
			'language_id' => '2',
			'room_id' => '1',
			'key' => 'block_1',
			'plugin_key' => 'accesscounters',
		),
		'AccessCounter' => array(
			'block_key' => 'block_1',
			'count' => '21',
			'count_start' => 0,
		),
	);

}
