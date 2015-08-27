<?php
/**
 * AccessCounter Model
 *
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AccessCountersAppModel', 'AccessCounters.Model');

/**
 * AccessCounter Model
 *
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package NetCommons\AccessCounters\Model
 */
class AccessCounter extends AccessCountersAppModel {

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
				'notEmpty' => array(
					'rule' => array('notEmpty'),
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
				'naturalNumber' => array(
					'rule' => array('naturalNumber', true),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => true,
				),
			),
		));

		return parent::beforeValidate($options);
	}

/**
 * Get accessCounter
 *
 * @param string $blockKey blocks.key
 * @param int $roomId rooms.id
 * @param bool $created If True, the results of the Model::find() to create it if it was null
 * @return array AccessCounter
 */
	public function getAccessCounter($blockKey, $roomId, $created) {
		$conditions[$this->alias . '.block_key'] = $blockKey;
		$conditions['Block.room_id'] = $roomId;

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
 * Save block
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
			'Frame' => 'Frames.Frame',
		]);

		//トランザクションBegin
		$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			//バリデーション
			if (! $this->validateAccessCounter($data, ['counterFrameSetting'])) {
				return false;
			}

			//ブロックの登録
			$block = $this->Block->saveByFrameId($data['Frame']['id']);

			//登録処理
			$this->data['AccessCounter']['block_key'] = $block['Block']['key'];
			if (! $this->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			if (isset($data['AccessCounterFrameSetting'])) {
				if (! $this->AccessCounterFrameSetting->save(null, false)) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				}
			}

			//トランザクションCommit
			$dataSource->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$dataSource->rollback();
			CakeLog::error($ex);
			throw $ex;
		}

		return true;
	}

/**
 * validate AccessCounter
 *
 * @param array $data received post data
 * @param array $contains Optional validate sets
 * @return bool True on success, false on error
 */
	public function validateAccessCounter($data, $contains = []) {
		$this->set($data);
		$this->validates();
		if ($this->validationErrors) {
			return false;
		}

		if (! $this->Block->validateBlock($data)) {
			$this->validationErrors = Hash::merge($this->validationErrors, $this->Block->validationErrors);
			return false;
		}

		if (isset($data['AccessCounterFrameSetting']) && in_array('counterFrameSetting', $contains, true)) {
			if (! $this->AccessCounterFrameSetting->validateAccessCounterFrameSetting($data)) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->AccessCounterFrameSetting->validationErrors);
				return false;
			}
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
		$this->setDataSource('master');

		$this->loadModels([
			'AccessCounter' => 'AccessCounters.AccessCounter',
			'Block' => 'Blocks.Block',
		]);

		//トランザクションBegin
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			if (! $this->deleteAll(array($this->alias . '.block_key' => $data['Block']['key']), false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//Blockデータ削除
			$this->Block->deleteBlock($data['Block']['key']);

			//トランザクションCommit
			$dataSource->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$dataSource->rollback();
			CakeLog::error($ex);
			throw $ex;
		}

		return true;
	}

/**
 * Save block
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
		$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			if (! $this->updateAll(
				array($this->name . '.count' => $this->name . '.count + 1'),
				array($this->name . '.id' => $data[$this->name]['id'])
			)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			};

			//トランザクションCommit
			$dataSource->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$dataSource->rollback();
			CakeLog::error($ex);
			throw $ex;
		}

		return true;
	}

}
