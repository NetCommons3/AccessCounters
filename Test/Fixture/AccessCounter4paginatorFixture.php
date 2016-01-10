<?php
/**
 * AccessCounterFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AccessCounterFixture', 'AccessCounters.Test/Fixture');

/**
 * AccessCountersFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\AccessCounters\Test\Fixture
 * @codeCoverageIgnore
 */
class AccessCounter4paginatorFixture extends AccessCounterFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'AccessCounter';

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'block_key' => 'block_1',
			'count' => 1,
			'count_start' => 0,
			'created_user' => 1,
			'created' => '2014-06-18 02:06:22',
			'modified_user' => 1,
			'modified' => '2014-06-18 02:06:22'
		),
		array(
			'id' => 2,
			'block_key' => 'block_2',
			'count' => 100,
			'count_start' => 10,
			'created_user' => 1,
			'created' => '2014-06-18 02:06:22',
			'modified_user' => 1,
			'modified' => '2014-06-18 02:06:22'
		),

		//101-200まで、ページ遷移のためのテスト

	);

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		for ($i = 101; $i <= 200; $i++) {
			$this->records[$i] = array(
				'id' => $i,
				'block_key' => 'block_' . $i,
				'count' => $i,
				'count_start' => $i,
			);
		}
		parent::init();
	}

}
