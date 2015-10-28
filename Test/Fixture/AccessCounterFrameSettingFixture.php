<?php
/**
 * AccessCounterFrameSettingFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * AccessCounterFrameSettingFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\AccessCounters\Test\Fixture
 */
class AccessCounterFrameSettingFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID |  |  | '),
		'frame_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'frame key | フレームKey | frames.key | ', 'charset' => 'utf8'),
		'display_type' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4, 'comment' => 'display type | 表示タイプ |  |'),
		'display_digit' => array('type' => 'integer', 'null' => false, 'default' => '3', 'length' => 4, 'comment' => 'display digit | 表示桁数 |  |'),
		'created_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'created user | 作成者 | users.id | '),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'created datetime | 作成日時 |  | '),
		'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'modified user | 更新者 | users.id | '),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'modified datetime | 更新日時 |  | '),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'frame_key' => 'frame_1',
			'display_type' => 2,
			'display_digit' => 1,
			'created_user' => 1,
			'created' => '2015-04-04 05:02:46',
			'modified_user' => 1,
			'modified' => '2015-04-04 05:02:46'
		),
		array(
			'id' => 2,
			'frame_key' => 'frame_2',
			'display_type' => 2,
			'display_digit' => 1,
			'created_user' => 1,
			'created' => '2015-04-04 05:02:46',
			'modified_user' => 1,
			'modified' => '2015-04-04 05:02:46'
		),
	);

}
