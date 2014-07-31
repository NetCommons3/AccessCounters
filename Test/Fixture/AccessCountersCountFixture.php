<?php
/**
 * AccessCountersCountFixture
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 * @since       NetCommons 3.0.0.0
 * @package     app.Plugin.AccessCounter.Test.Fixture
 */

/**
 * AccessCountersCountFixture
 *
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since       NetCommons 3.0.0.0
 * @package     app.Plugin.AccessCounter.Test.Case
 */
class AccessCountersCountFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since    NetCommons 3.0.0.0
 * @var      array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'access_counter_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'language_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'access_count' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'created_user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'idx_access_counters' => array('column' => 'access_counter_id', 'unique' => 0),
			'idx_block_languages' => array('column' => array('block_id', 'language_id'), 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since    NetCommons 3.0.0.0
 * @var      array
 */
	public $records = array(
		array(
			'id' => 1,
			'access_counter_id' => 1,
			'block_id' => 1,
			'language_id' => 2,
			'access_count' => 1,
			'created' => '2014-07-08 15:34:16',
			'created_user_id' => 1,
			'modified' => '2014-07-08 15:34:16',
			'modified_user_id' => 1
		),
	);

}
