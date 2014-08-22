<?php
/**
 * AccessCountersFormatFixture
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 * @package     app.Plugin.AccessCounter.Test.Fixture
 */

/**
 * AccessCountersFormatFixture
 *
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package     app.Plugin.AccessCounter.Test.Case
 */
class AccessCountersFormatFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @var      array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'access_counter_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'language_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'status_id' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 3, 'comment' => '1: for Publish    2: for PublishRequest    3: for Draft    4: for Reject'),
		'is_original' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 1, 'comment' => '1: for original    0: for auto translation'),
		'show_number_image' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'show_digit_number' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 3),
		'show_format' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created_user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'idx_access_counter_id' => array('column' => array('access_counter_id', 'status_id'), 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @var      array
 */
	public $records = array(
		array(
			'id' => 1,
			'access_counter_id' => 1,
			'block_id' => 1,
			'language_id' => 2,
			'status_id' => 1,
			'is_original' => 1,
			'show_number_image' => ' ',
			'show_digit_number' => 10,
			'show_format' => 'COUNTER {X-NUMBER-IMAGE}',
			'created_user_id' => 1,
			'created' => '2014-07-08 15:34:37',
			'modified_user_id' => 1,
			'modified' => '2014-07-08 15:34:37'
		),
		array(
			'id' => 2,
			'access_counter_id' => 1,
			'block_id' => 1,
			'language_id' => 2,
			'status_id' => 1,
			'is_original' => 1,
			'show_number_image' => ' ',
			'show_digit_number' => 10,
			'show_format' => 'Prefix1 {X-NUMBER-IMAGE} Suffix1',
			'created_user_id' => 1,
			'created' => '2014-07-08 15:34:37',
			'modified_user_id' => 1,
			'modified' => '2014-07-08 15:34:37'
		),
		array(
			'id' => 3,
			'access_counter_id' => 1,
			'block_id' => 1,
			'language_id' => 2,
			'status_id' => 2,
			'is_original' => 1,
			'show_number_image' => ' ',
			'show_digit_number' => 10,
			'show_format' => 'Prefix2 {X-NUMBER-IMAGE} Suffix2',
			'created_user_id' => 1,
			'created' => '2014-07-08 15:34:37',
			'modified_user_id' => 1,
			'modified' => '2014-07-08 15:34:37'
		),
		array(
			'id' => 4,
			'access_counter_id' => 2,
			'block_id' => 2,
			'language_id' => 2,
			'status_id' => 3,
			'is_original' => 1,
			'show_number_image' => ' ',
			'show_digit_number' => 10,
			'show_format' => 'COUNTER {X-NUMBER-IMAGE}',
			'created_user_id' => 1,
			'created' => '2014-07-08 15:34:37',
			'modified_user_id' => 1,
			'modified' => '2014-07-08 15:34:37'
		),
		array(
			'id' => 5,
			'access_counter_id' => 2,
			'block_id' => 2,
			'language_id' => 2,
			'status_id' => 2,
			'is_original' => 1,
			'show_number_image' => ' ',
			'show_digit_number' => 10,
			'show_format' => 'COUNTER {X-NUMBER-IMAGE}',
			'created_user_id' => 1,
			'created' => '2014-07-08 15:34:37',
			'modified_user_id' => 1,
			'modified' => '2014-07-08 15:34:37'
		),
		array(
			'id' => 11,
			'access_counter_id' => 11,
			'block_id' => 11,
			'language_id' => 2,
			'status_id' => 1,
			'is_original' => 1,
			'show_number_image' => ' ',
			'show_digit_number' => 10,
			'show_format' => 'COUNTER {X-NUMBER-IMAGE}',
			'created_user_id' => 1,
			'created' => '2014-07-08 15:34:37',
			'modified_user_id' => 1,
			'modified' => '2014-07-08 15:34:37'
		),
		array(
			'id' => 12,
			'access_counter_id' => 12,
			'block_id' => 12,
			'language_id' => 2,
			'status_id' => 2,
			'is_original' => 1,
			'show_number_image' => ' ',
			'show_digit_number' => 10,
			'show_format' => 'COUNTER {X-NUMBER-IMAGE}',
			'created_user_id' => 1,
			'created' => '2014-07-08 15:34:37',
			'modified_user_id' => 1,
			'modified' => '2014-07-08 15:34:37'
		),
		array(
			'id' => 13,
			'access_counter_id' => 13,
			'block_id' => 13,
			'language_id' => 2,
			'status_id' => 3,
			'is_original' => 1,
			'show_number_image' => ' ',
			'show_digit_number' => 10,
			'show_format' => 'COUNTER {X-NUMBER-IMAGE}',
			'created_user_id' => 1,
			'created' => '2014-07-08 15:34:37',
			'modified_user_id' => 1,
			'modified' => '2014-07-08 15:34:37'
		),
		array(
			'id' => 14,
			'access_counter_id' => 14,
			'block_id' => 14,
			'language_id' => 2,
			'status_id' => 4,
			'is_original' => 1,
			'show_number_image' => ' ',
			'show_digit_number' => 10,
			'show_format' => 'COUNTER {X-NUMBER-IMAGE}',
			'created_user_id' => 1,
			'created' => '2014-07-08 15:34:37',
			'modified_user_id' => 1,
			'modified' => '2014-07-08 15:34:37'
		),
	);

}
