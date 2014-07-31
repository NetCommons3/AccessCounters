<?php
/**
 * AccessCounter Model
 *
 * @property Block $Block
 * @property Language $Language
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 * @since       NetCommons 3.0.0.0
 * @package     app.Plugin.AccessCounters.Model
 */

App::uses('AccessCountersAppModel', 'AccessCounters.Model');

/**
 * AccessCounter Model
 *
 * @property Block $Block
 * @property Language $Language
 *
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since       NetCommons 3.0.0.0
 * @package     app.Plugin.AccessCounters.Model
 */
class AccessCounter extends AccessCountersAppModel {

/**
 * Validation rules
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @var     array
 */
	public $validate = array(
		'block_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Security Error! Unauthorized input. (block_id)',
			),
		),
		'created_user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Security Error! Unauthorized input. (created_user_id)',
			),
		),
		'modified_user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Security Error! Unauthorized input. (modified_user_id)',
				),
		),
	);

/**
 * belongsTo associations
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @var     array
 */
	public $belongsTo = array(
		'Block' => array(
			'className' => 'Block',
			'foreignKey' => 'block_id',
			'conditions' => '',
			'type' => 'inner',
			'fields' => '',
			'order' => ''
		),
	);

/**
 * hasAndBelongsToMany associations
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @var     array
 */
	//public $hasAndBelongsToMany = array(
	//	'Language' => array(
	//		'className' => 'Language',
	//		'joinTable' => 'access_counters_languages',
	//		'foreignKey' => 'access_counter_id',
	//		'associationForeignKey' => 'language_id',
	//		'unique' => 'keepExisting',
	//		'conditions' => '',
	//		'fields' => '',
	//		'order' => '',
	//		'limit' => '',
	//		'offset' => '',
	//		'finderQuery' => '',
	//	)
	//);

}
