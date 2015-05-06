<?php
/**
 * AccessCounterFrameSetting Model
 *
 * @property AccessCounters $AccessCounters
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AccessCountersAppModel', 'AccessCounters.Model');

/**
 * AccessCounterFrameSetting Model
 */
class AccessCounterFrameSetting extends AccessCountersAppModel {

/**
 * Displau type
 *
 * @var string
 */
	const DISPLAY_TYPE_LABEL_0 = 'default',
			DISPLAY_TYPE_LABEL_1 = 'primary',
			DISPLAY_TYPE_LABEL_2 = 'success',
			DISPLAY_TYPE_LABEL_3 = 'info',
			DISPLAY_TYPE_LABEL_4 = 'warning',
			DISPLAY_TYPE_LABEL_5 = 'danger';

/**
 * categorySeparatorLine
 *
 * @var array
 */
	static public $displayTypes = array(
		'1' => self::DISPLAY_TYPE_LABEL_0,
		'2' => self::DISPLAY_TYPE_LABEL_1,
		'3' => self::DISPLAY_TYPE_LABEL_2,
		'4' => self::DISPLAY_TYPE_LABEL_3,
		'5' => self::DISPLAY_TYPE_LABEL_4,
		'6' => self::DISPLAY_TYPE_LABEL_5,
	);

/**
 * Min value of displau digit
 *
 * @var int
 */
	const DISPLAY_DIGIT_MIN = 3;

/**
 * max value of displau digit
 *
 * @var int
 */
	const DISPLAY_DIGIT_MAX = 9;

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

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
		$displayTypes = array_keys(self::$displayTypes);

		$this->validate = Hash::merge($this->validate, array(
			'frame_key' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'display_type' => array(
				'inList' => array(
					'rule' => array('inList', $displayTypes),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => true,
				)
			),
			'display_digit' => array(
				'naturalNumber' => array(
					'rule' => array('naturalNumber', true),
					'message' => __d('net_commons', 'Invalid request.'),
				),
				'numeric' => array(
					'rule' => array('range', self::DISPLAY_DIGIT_MIN - 1, self::DISPLAY_DIGIT_MAX + 1),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
		));
	}

/**
 * Get access counter setting data
 *
 * @param string $frameKey frames.key
 * @return array
 */
	public function getAccessCounterFrameSetting($frameKey) {
		$conditions = array(
			'frame_key' => $frameKey
		);

		$counterFrameSetting = $this->find('first', array(
				'recursive' => -1,
				'conditions' => $conditions,
			)
		);

		return $counterFrameSetting;
	}

/**
 * Save access counter settings
 *
 * @param array $data received post data
 * @return bool True on success, false on failure
 * @throws InternalErrorException
 */
	public function saveAccessCounterFrameSetting($data) {
		$this->loadModels([
			'AccessCounterFrameSetting' => 'AccessCounters.AccessCounterFrameSetting',
		]);

		//トランザクションBegin
		$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			if (! $this->validateAccessCounterFrameSetting($data)) {
				return false;
			}

			if (! $this->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
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
 * validate AccessCounterFrameSetting
 *
 * @param array $data received post data
 * @return bool True on success, false on error
 */
	public function validateAccessCounterFrameSetting($data) {
		$this->set($data);
		$this->validates();
		if ($this->validationErrors) {
			return false;
		}
		return true;
	}
}
