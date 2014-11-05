<?php
/**
 * Migration file
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * Migration CakeMigration
 *
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package NetCommons\AccessCounters\Config\Migration
 */
class AccessCounters extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = '';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'alter_field' => array(
				'access_counter_frame_settings' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID |  |  | '),
					'frame_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'frame key | フレームKey | frames.key | ', 'charset' => 'utf8'),
					'display_type' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4, 'comment' => 'display type | 表示タイプ |  |'),
					'display_digit' => array('type' => 'integer', 'null' => false, 'default' => '3', 'length' => 4, 'comment' => 'display digit | 表示桁数 |  |'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'created user | 作成者 | users.id | '),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'created datetime | 作成日時 |  | '),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'modified user | 更新者 | users.id | '),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'modified datetime | 更新日時 |  | '),
				),
				'access_counters' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID |  |  | '),
					'block_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'block key | ブロックKey | blocks.key | ', 'charset' => 'utf8'),
					'count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'comment' => 'Number of counts | カウント数 |  |'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'created user | 作成者 | users.id | '),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'created datetime | 作成日時 |  | '),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'modified user | 更新者 | users.id | '),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'modified datetime | 更新日時 |  | '),
				),
			),
			'create_field' => array(
				'access_counters' => array(
					'count_start' => array('type' => 'integer', 'null' => false, 'default' => '0', 'comment' => 'Count start value | カウント開始値 |  |', 'after' => 'count'),
				),
			),
			'drop_field' => array(
				'access_counters' => array('starting_count'),
			),
		),
		'down' => array(
			'alter_field' => array(
				'access_counter_frame_settings' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'frame_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'display_type' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4),
					'display_digit' => array('type' => 'integer', 'null' => false, 'default' => '3', 'length' => 4),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
				),
				'access_counters' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'block_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Key of the block.', 'charset' => 'utf8'),
					'count' => array('type' => 'integer', 'null' => false, 'default' => '0'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
				),
			),
			'drop_field' => array(
				'access_counters' => array('count_start'),
			),
			'create_field' => array(
				'access_counters' => array(
					'starting_count' => array('type' => 'integer', 'null' => false, 'default' => '0'),
				),
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction up or down direction of migration process
 * @return boolean Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction up or down direction of migration process
 * @return boolean Should process continue
 */
	public function after($direction) {
		return true;
	}
}
