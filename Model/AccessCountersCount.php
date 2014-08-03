<?php
/**
 * AccessCountersCount Model
 *
 * @property AccessCounter $AccessCounter
 * @property Block $Block
 * @property Language $Language
 * @property AccessCountersFormat $AccessCountersFormat
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
 * AccessCountersCount Model
 *
 * @property AccessCounter $AccessCounter
 * @property Block $Block
 * @property Language $Language
 * @property AccessCountersFormat $AccessCountersFormat
 *
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since       NetCommons 3.0.0.0
 * @package     app.Plugin.AccessCounters.Model
 */
class AccessCountersCount extends AccessCountersAppModel {

/**
 * Validation rules
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @var     array
 */
	public $validate = array(
		'access_counter_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Security Error! Unauthorized input. (access_counter_id)',
			),
		),
		'block_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Security Error! Unauthorized input. (block_id)',
			),
		),
		'language_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Security Error! Unauthorized input. (language_id)',
			),
		),
		'access_count' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Security Error! Unauthorized input. (access_count)',
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
		'AccessCounter' => array(
			'className' => 'AccessCounter',
			'foreignKey' => 'access_counter_id',
			'conditions' => '',
			'type' => 'inner',
			'fields' => '',
			'order' => ''
		),
		//'Block' => array(
		//	'className' => 'Block',
		//	'foreignKey' => 'block_id',
		//	'conditions' => '',
		//	'fields' => '',
		//	'order' => ''
		//),
		'Language' => array(
			'className' => 'Language',
			'foreignKey' => 'language_id',
			'conditions' => '',
			'type' => 'inner',
			'fields' => '',
			'order' => ''
		),
	);

/**
 * get data
 *
 * @param int $blockId blocks.id
 * @param int $langId languages.id
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @return  int
 */
	public function getAccessCount($blockId, $langId) {
		$count = 0;

		$accessCount = $this->find('first', array(
			'conditions' => array(
				'AccessCountersCount.block_id' => $blockId,
				'AccessCountersCount.language_id' => $langId,
			),
		));

		if ($accessCount) {
			$count = $accessCount['AccessCountersCount']['access_count'];
		}

		return $count;
	}

/**
 * save count up
 *
 * @param int $blockId blocks.id
 * @param int $langId languages.id
 * @param int $userId users.id
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @return  int
 */
	public function saveCountUp($blockId, $langId, $userId) {
		$accessCounter = $this->AccessCounter->findByBlockId($blockId);
		if (! $accessCounter) {
			return null;
		}

		$userId = intval($userId);

		$data = $this->find('first', array(
			'conditions' => array(
				'AccessCountersCount.block_id' => $blockId,
				'AccessCountersCount.language_id' => $langId,
			),
		));

		if (! $data) {
			$data['AccessCountersCount']['access_counter_id'] = $accessCounter['AccessCounter']['id'];
			$data['AccessCountersCount']['block_id'] = $blockId;
			$data['AccessCountersCount']['language_id'] = $langId;
			$data['AccessCountersCount']['access_count'] = 1;
			$data['AccessCountersCount']['created_user_id'] = $userId;
		} else {
			$data['AccessCountersCount']['access_count'] = $data['AccessCountersCount']['access_count'] + 1;
		}
		$data['AccessCountersCount']['modified_user_id'] = $userId;

		//保存結果を返す
		$rtn = $this->save($data);
		//id が戻ってこないなら、insert失敗
		if (isset($rtn[$this->name])
			&& isset($rtn[$this->name]['id'])
			&& $rtn[$this->name]['id']
		) {
			return $rtn;
		} else {
			return null;
		}
	}

}
