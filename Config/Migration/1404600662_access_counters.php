<?php
/**
 * Migration file
 *
 * @author        Noriko Arai <arai@nii.ac.jp>
 * @author        Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link          http://www.netcommons.org NetCommons Project
 * @license       http://www.netcommons.org/license.txt NetCommons License
 * @copyright    Copyright 2014, NetCommons Project
 */

/**
 * AccessCounters CakeMigration
 *
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package     app.Plugin.AccessCounters.Config.Migration
 */
class AccessCounters extends CakeMigration {

/**
 * Migration description
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @var     string
 */
	public $description = '';

/**
 * Actions to be performed
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @var     array $migration
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(
				'access_counters' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'created_user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'modified_user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'fk_access_counters_blocks1_idx' => array('column' => 'block_id', 'unique' => 0),
						'fk_access_counters_users1_idx' => array('column' => 'created_user_id', 'unique' => 0),
						'fk_access_counters_users2_idx' => array('column' => 'modified_user_id', 'unique' => 0),
						'idx_block_id' => array('column' => 'block_id', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
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
		'down' => array(
			'drop_table' => array(
				'access_counters', 'access_counters_counts', 'access_counters_formats'
			),
		),
	);

/**
 * recodes
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @var      array $records
 */
	public $records = array();

/**
 * Before migration callback
 *
 * @param string $direction up or down direction of migration process
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction up or down direction of migration process
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return bool Should process continue
 */
	public function after($direction) {
		if ($direction === 'down') {
			return true;
		}

		foreach ($this->records as $model => $records) {
			if (!$this->updateRecords($model, $records)) {
				return false;
			}
		}

		return true;
	}

/**
 * Update model records
 *
 * @param string $model model name to update
 * @param string $records records to be stored
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return  bool Should process continue
 */
	public function updateRecords($model, $records) {
		$Model = $this->generateModel($model);
		foreach ($records as $record) {
			$Model->create();
			if (!$Model->save($record, false)) {
				return false;
			}
		}

		return true;
	}

}
