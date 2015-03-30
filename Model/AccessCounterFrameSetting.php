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
 * Use database config
 *
 * @var string
 */
	public $useDbConfig = 'master';

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
		$this->validate = Hash::merge($this->validate, array(
			'frame_key' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'display_type' => array(
				'naturalNumber' => array(
					'rule' => array('naturalNumber', true),
					'message' => __d('net_commons', 'Invalid request.'),
				),
				'range' => array(
					'rule' => array('range', -1, 6),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'display_digit' => array(
				'naturalNumber' => array(
					'rule' => array('naturalNumber', true),
					'message' => __d('net_commons', 'Invalid request.'),
				),
				'numeric' => array(
					'rule' => array('range', 2, 10),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
		));
	}

/**
 * save setting
 *
 * @param array $data received post data
 * @return string $blockKey blocks.key
 * @throws InternalErrorException
 * @SuppressWarnings(PHPMD.LongVariable)
 */
	public function saveSetting($data) {
		$this->loadModels([
			'Frame' => 'Frames.Frame',
			'Block' => 'Blocks.Block',
			'AccessCounter' => 'AccessCounters.AccessCounter',
		]);

		//トランザクションBegin
		$dataSource = $this->getDataSource();
		$dataSource->begin();
		try {
			if (!$this->AccessCounter->validateAccessCounter($data)) {
				return false;
			}

			if (!$this->validateAccessCounterFrameSetting($data)) {
				return false;
			}

			// ブロックの登録処理
			$frame = $this->__saveBlock($data['Frame']['id']);
			$blockKey = $frame['Block']['key'];

			// カウント開始前
			if (! $data['AccessCounter']['is_started']) {
				unset($data['AccessCounter']['is_started']);

				// AccessCounterの新規登録
				$AccessCounter = array('AccessCounter' => $data['AccessCounter']);
				$AccessCounter['AccessCounter']['block_key'] = $blockKey;
				$AccessCounter['AccessCounter']['count'] = $AccessCounter['AccessCounter']['count_start'];
				$AccessCounter = $this->AccessCounter->save($AccessCounter);
				if (!$AccessCounter) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				}
			}

			// AccessCounterFrameSettingの新規登録 or 更新
			$AccessCounterFrameSetting = array('AccessCounterFrameSetting' => $data['AccessCounterFrameSetting']);
			$AccessCounterFrameSetting['AccessCounterFrameSetting']['frame_key'] = $frame['Frame']['key'];
			$AccessCounterFrameSetting = $this->save($AccessCounterFrameSetting);
			if (!$AccessCounterFrameSetting) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			$dataSource->commit();
			return true;
		} catch (Exception $ex) {
			$dataSource->rollback();
			CakeLog::error($ex);
			throw $ex;
		}
	}

/**
 * save block
 *
 * @param int $frameId frames.id
 * @return array $frame
 * @throws InternalErrorException
 */
	private function __saveBlock($frameId) {
		$frame = $this->Frame->findById($frameId);

		// 紐づくブロックが既に存在する
		if (isset($frame['Frame']['block_id']) &&
			$frame['Frame']['block_id'] !== '0') {

			return $frame;
		}

		//blockの新規登録
		$block = array(
			'room_id' => $frame['Frame']['room_id'],
			'language_id' => $frame['Frame']['language_id'],
		);
		$block = $this->Block->save($block);
		if (! $block) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		//frameの更新
		$frame['Block'] = $block['Block'];
		$frame['Frame']['block_id'] = $block['Block']['id'];
		if (! $this->Frame->save($frame)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		return $frame;
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
		return $this->validationErrors ? false : true;
	}
}
