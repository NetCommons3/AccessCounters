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
	public $validate = array(
		'frame_key' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'display_type' => array(
			'naturalNumber' => array(
				'rule' => array('naturalNumber', true),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'range' => array(
				'rule' => array('range', -1, 6),
				//'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'display_digit' => array(
			'naturalNumber' => array(
				'rule' => array('naturalNumber', true),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'numeric' => array(
				'rule' => array('range', 2, 10),
				//'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

/**
 * before save
 *
 * @param array $options Options passed from Model::save().
 * @return bool True if the operation should continue, false if it should abort
 */
	public function beforeSave($options = array()) {
		if (! isset($this->data[$this->name]['id']) || empty($this->data[$this->name]['id'])) {
			$this->data[$this->name]['created_user'] = CakeSession::read('Auth.User.id');
		}
		$this->data[$this->name]['modified_user'] = CakeSession::read('Auth.User.id');
		return true;
	}

/**
 * save setting
 *
 * @param array $postData received post data
 * @return string $blockKey blocks.key
 * @throws ForbiddenException
 * @SuppressWarnings(PHPMD.LongVariable)
 */
	public function saveSetting($postData) {
		$models = array(
			'Frame' => 'Frames.Frame',
			'Block' => 'Blocks.Block',
			'AccessCounter' => 'AccessCounters.AccessCounter',
		);
		foreach ($models as $model => $class) {
			$this->$model = ClassRegistry::init($class);
		}

		//DBへの登録
		$dataSource = $this->getDataSource();
		$dataSource->begin();
		try {
			// ブロックの登録処理
			$frame = $this->__saveBlock($postData['Frame']['id']);
			$blockKey = $frame['Block']['key'];

			// カウント開始前
			if ($postData['AccessCounter']['is_started'] === 'false') {

				// AccessCounterの新規登録
				$AccessCounter = array('AccessCounter' => $postData['AccessCounter']);
				$AccessCounter['AccessCounter']['block_key'] = $blockKey;
				$AccessCounter['AccessCounter']['count'] = $AccessCounter['AccessCounter']['count_start'];
				$AccessCounter = $this->AccessCounter->save($AccessCounter);
				if (!$AccessCounter) {
					return false;
				}
			}

			// AccessCounterFrameSettingの新規登録 or 更新
			$AccessCounterFrameSetting = array('AccessCounterFrameSetting' => $postData['AccessCounterFrameSetting']);
			$AccessCounterFrameSetting['AccessCounterFrameSetting']['frame_key'] = $frame['Frame']['key'];
			$AccessCounterFrameSetting = $this->save($AccessCounterFrameSetting);
			if (!$AccessCounterFrameSetting) {
				return false;
			}

			$dataSource->commit();
			return $blockKey;
		} catch (Exception $ex) {
			$dataSource->rollback();
			return false;
		}
	}

/**
 * save block
 *
 * @param int $frameId frames.id
 * @return array $frame
 * @throws ForbiddenException
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
			throw new ForbiddenException(serialize($this->Block->validationErrors));
		}

		//frameの更新
		$frame['Block'] = $block['Block'];
		$frame['Frame']['block_id'] = $block['Block']['id'];
		if (! $this->Frame->save($frame)) {
			throw new ForbiddenException(serialize($this->Frame->validationErrors));
		}

		return $frame;
	}
}
