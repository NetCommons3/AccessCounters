<?php
/**
 * AccessCounter Model
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AccessCountersAppModel', 'AccessCounters.Model');

/**
 * AccessCounter Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\AccessCounters\Model
 */
class AccessCounter extends AccessCountersAppModel {

/**
 * 初期値のMax
 *
 * @var const
 */
	const MAX_VALUE = 9999999;

/**
 * use behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'Blocks.Block'
	);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Block' => array(
			'className' => 'Blocks.Block',
			'foreignKey' => false,
			'conditions' => 'AccessCounter.block_key = Block.key',
			'fields' => '',
		),
	);

/**
 * Called during validation operations, before validation. Please note that custom
 * validation rules can be defined in $validate.
 *
 * @param array $options Options passed from Model::save().
 * @return bool True if validate operation should continue, false to abort
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#beforevalidate
 * @see Model::save()
 */
	public function beforeValidate($options = array()) {
		$this->validate = Hash::merge($this->validate, array(
			'block_key' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => __d('net_commons', 'Invalid request.'),
					'required' => true,
					'on' => 'update', // Limit validation to 'create' or 'update' operations
				),
			),
			'count' => array(
				'naturalNumber' => array(
					'rule' => array('naturalNumber', true),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => true,
				),
			),
			'count_start' => array(
				'range' => array(
					'rule' => array('range', -1, self::MAX_VALUE + 1),
					'message' => __d(
						'net_commons',
						'The input %s must be a number bigger than %d and less than %d.',
						array(__d('access_counters', 'Starting Value'), 0, self::MAX_VALUE)
					),
					'allowEmpty' => true,
				),
			),
		));

		return parent::beforeValidate($options);
	}

/**
 * Get AccessCounter
 *
 * @param bool $created If True, the results of the Model::find() to create it if it was null
 * @return array AccessCounter
 */
	public function getAccessCounter($created) {
		$this->loadModels([
			'Block' => 'Blocks.Block',
		]);
		$conditions[$this->alias . '.block_key'] = Current::read('Block.key');
		$conditions['Block.room_id'] = Current::read('Block.room_id');

		$accessCounter = $this->find('first', array(
			'recursive' => 0,
			'conditions' => $conditions,
		));

		if ($created && ! $accessCounter) {
			$accessCounter = $this->create();
		}

		return $accessCounter;
	}

/**
 * Save AccessCounter
 *
 * @param array $data received post data
 * @return bool True on success, false on validation errors
 * @throws InternalErrorException
 */
	public function saveAccessCounter($data) {
		$this->loadModels([
			'AccessCounter' => 'AccessCounters.AccessCounter',
			'AccessCounterFrameSetting' => 'AccessCounters.AccessCounterFrameSetting',
			'Block' => 'Blocks.Block',
		]);

		//トランザクションBegin
		$this->begin();

		//バリデーション
		if (! $this->validateAccessCounter($data)) {
			return false;
		}

		try {
			//登録処理
			if (! $this->data = $this->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			if (isset($data['AccessCounterFrameSetting'])) {
				if (! $this->AccessCounterFrameSetting->save(null, false)) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				}
			}

			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
		}

		return true;
	}

/**
 * validate AccessCounter
 *
 * @param array $data received post data
 * @return bool True on success, false on error
 */
	public function validateAccessCounter($data) {
		$this->loadModels([
			'BlocksLanguage' => 'Blocks.BlocksLanguage',
		]);
		$this->BlocksLanguage->validate['name'] = array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => sprintf(
					__d('net_commons', 'Please input %s.'), __d('access_counters', 'Access counter name')
				),
			),
		);

		//バリデーション
		$this->set($data);
		if (! $this->validates()) {
			return false;
		}

		$this->BlocksLanguage->set($data);
		if (! $this->BlocksLanguage->validates()) {
			$this->validationErrors = Hash::merge(
				$this->validationErrors, $this->BlocksLanguage->validationErrors
			);
			return false;
		}
		$this->data = Hash::merge($this->data, $this->BlocksLanguage->data);

		$this->AccessCounterFrameSetting->set($data);
		if (! $this->AccessCounterFrameSetting->validates()) {
			$this->validationErrors = Hash::merge(
				$this->validationErrors, $this->AccessCounterFrameSetting->validationErrors
			);
			return false;
		}

		return true;
	}

/**
 * Delete block
 *
 * @param array $data received post data
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function deleteAccessCounter($data) {
		$this->loadModels([
			'AccessCounter' => 'AccessCounters.AccessCounter',
		]);

		//トランザクションBegin
		$this->begin();

		try {
			if (! $this->deleteAll(array($this->alias . '.block_key' => $data['Block']['key']), false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//Blockデータ削除
			$this->deleteBlock($data['Block']['key']);

			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
		}

		return true;
	}

/**
 * カウントの更新
 *
 * @param array $data received post data
 * @return bool True on success, false on validation errors
 * @throws InternalErrorException
 */
	public function updateCountUp($data) {
		$this->loadModels([
			'AccessCounter' => 'AccessCounters.AccessCounter',
		]);

		//トランザクションBegin
		$this->begin();

		try {
			if (! $this->updateAll(
				array($this->alias . '.count' => $this->alias . '.count + 1'),
				array($this->alias . '.id' => $data[$this->alias]['id'])
			)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			};

			//トランザクションCommit
			$this->commit();
			$this->setSlaveDataSource();
			$this->getDataSource();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
		}

		return true;
	}

}
