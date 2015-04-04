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
class AccessCountersRenewal extends CakeMigration {

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
			'create_table' => array(
				'access_counter_frame_settings' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'frame_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'display_type' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4),
					'display_digit' => array('type' => 'integer', 'null' => false, 'default' => '3', 'length' => 4),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
			),
			'create_field' => array(
				'access_counters' => array(
					'block_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Key of the block.', 'charset' => 'utf8', 'after' => 'id'),
					'count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'after' => 'block_key'),
					'starting_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'after' => 'count'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'after' => 'starting_count'),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'after' => 'created'),
				),
			),
			'drop_field' => array(
				'access_counters' => array('block_id', 'created_user_id', 'modified_user_id', 'indexes' => array('fk_access_counters_blocks1_idx', 'fk_access_counters_users1_idx', 'fk_access_counters_users2_idx', 'idx_block_id')),
			),
			'alter_field' => array(
				'access_counters' => array(
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
				),
			),
			'drop_table' => array(
				'access_counters_counts', 'access_counters_formats'
			),
		),
		'down' => array(
			'drop_table' => array(
				'access_counter_frame_settings',
			),
			'drop_field' => array(
				'access_counters' => array('block_key', 'count', 'starting_count', 'created_user', 'modified_user'),
			),
			'create_field' => array(
				'access_counters' => array(
					'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
					'created_user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
					'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
					'indexes' => array(
						'fk_access_counters_blocks1_idx' => array('column' => 'block_id', 'unique' => 0),
						'fk_access_counters_users1_idx' => array('column' => 'created_user_id', 'unique' => 0),
						'fk_access_counters_users2_idx' => array('column' => 'modified_user_id', 'unique' => 0),
						'idx_block_id' => array('column' => 'block_id', 'unique' => 0),
					),
				),
			),
			'alter_field' => array(
				'access_counters' => array(
					'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
				),
			),
			'create_table' => array(
				'access_counters_counts' => array(
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
						'fk_access_counters_blocks1_idx' => array('column' => 'block_id', 'unique' => 0),
						'fk_access_counters_users1_idx' => array('column' => 'created_user_id', 'unique' => 0),
						'fk_access_counters_users2_idx' => array('column' => 'modified_user_id', 'unique' => 0),
						'idx_access_counters' => array('column' => 'access_counter_id', 'unique' => 0),
						'fk_access_counters_logs_languages1_idx' => array('column' => 'language_id', 'unique' => 0),
						'fk_access_counters_counts_access_counters1_idx' => array('column' => 'access_counter_id', 'unique' => 0),
						'idx_block_languages' => array('column' => array('block_id', 'language_id'), 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'access_counters_formats' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'access_counter_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
					'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
					'language_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
					'status_id' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 3, 'key' => 'index', 'comment' => '1: for Publish    2: for PublishRequest    3: for Draft    4: for Reject'),
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
						'fk_access_counters_languages_users1_idx' => array('column' => 'created_user_id', 'unique' => 0),
						'fk_access_counters_languages_users2_idx' => array('column' => 'modified_user_id', 'unique' => 0),
						'idx_access_counter_count_id' => array('column' => 'status_id', 'unique' => 0),
						'fk_access_counters_formats_access_counters1_idx' => array('column' => 'access_counter_id', 'unique' => 0),
						'fk_access_counters_formats_languages1_idx' => array('column' => 'language_id', 'unique' => 0),
						'fk_access_counters_formats_blocks1_idx' => array('column' => 'block_id', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction up or down direction of migration process
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction up or down direction of migration process
 * @return bool Should process continue
 */
	public function after($direction) {
		return true;
	}
}
