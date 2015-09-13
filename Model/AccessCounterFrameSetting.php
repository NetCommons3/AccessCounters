<?php
/**
 * AccessCounterFrameSetting Model
 *
 * @property AccessCounters $AccessCounters
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AccessCountersAppModel', 'AccessCounters.Model');

/**
 * AccessCounterFrameSetting Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\AccessCounters\Model
 */
class AccessCounterFrameSetting extends AccessCountersAppModel {

/**
 * Display type
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
 * Display type value
 *
 * @var string
 */
	const DISPLAY_TYPE_VALUE_0 = '1',
			DISPLAY_TYPE_VALUE_1 = '2',
			DISPLAY_TYPE_VALUE_2 = '3',
			DISPLAY_TYPE_VALUE_3 = '4',
			DISPLAY_TYPE_VALUE_4 = '5',
			DISPLAY_TYPE_VALUE_5 = '6';

/**
 * categorySeparatorLine
 *
 * @var array
 */
	static public $displayTypes = array(
		self::DISPLAY_TYPE_VALUE_0 => self::DISPLAY_TYPE_LABEL_0,
		self::DISPLAY_TYPE_VALUE_1 => self::DISPLAY_TYPE_LABEL_1,
		self::DISPLAY_TYPE_VALUE_2 => self::DISPLAY_TYPE_LABEL_2,
		self::DISPLAY_TYPE_VALUE_3 => self::DISPLAY_TYPE_LABEL_3,
		self::DISPLAY_TYPE_VALUE_4 => self::DISPLAY_TYPE_LABEL_4,
		self::DISPLAY_TYPE_VALUE_5 => self::DISPLAY_TYPE_LABEL_5,
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
				'notBlank' => array(
					'rule' => array('notBlank'),
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

		return parent::beforeValidate($options);
	}

/**
 * Get access counter setting data
 *
 * @param bool $created If True, the results of the Model::find() to create it if it was null
 * @return array
 */
	public function getAccessCounterFrameSetting($created) {
		$conditions = array(
			'frame_key' => Current::read('Frame.key')
		);

		$counterFrameSetting = $this->find('first', array(
			'recursive' => -1,
			'conditions' => $conditions,
		));

		if ($created && ! $counterFrameSetting) {
			$counterFrameSetting = $this->create(array(
				'id' => null,
				'display_type' => self::DISPLAY_TYPE_VALUE_0,
			));
		}

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
		$this->begin();

		//バリデーション
		$this->set($data);
		if (! $this->validates()) {
			$this->rollback();
			return false;
		}

		try {
			if (! $this->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
		}

		return true;
	}
}
