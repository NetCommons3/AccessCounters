<?php
/**
 * AccessCountersFormat Model
 *
 * @property AccessCountersCount $AccessCountersCount
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
 * AccessCountersFormat Model
 *
 * @property AccessCountersCount $AccessCountersCount
 *
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since       NetCommons 3.0.0.0
 * @package     app.Plugin.AccessCounters.Model
 */
class AccessCountersFormat extends AccessCountersAppModel {

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
		'status_id' => array(
			'numeric' => array(
				'rule' => array('range', 0, 4),
				'message' => 'The input `status_id` must be a number bigger than 4 and less than 1.',
			),
		),
		'is_original' => array(
			'numeric' => array(
				'rule' => array('boolean'),
			),
		),
		'show_number_image' => array(
			'numberImage' => array(
				'rule' => array('numberImage'),
				'message' => 'Please select image.',
			),
		),
		'show_digit_number' => array(
			'numeric' => array(
				'rule' => array('range', 1, 10),
				'message' => 'The input `show_digit_number` must be a number bigger than 10 and less than 1.',
			),
		),
	);

/**
 * validate rule show_number_image
 *
 * @param string $data imagePath
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @return  array
 */
	public function numberImage($data) {
		$imgPath = ROOT . DS . 'app' . DS . 'Plugin' . DS . $this->plugin . DS . WEBROOT_DIR . DS . 'img' . DS . '*';
		$options = array_map('basename', glob($imgPath, GLOB_ONLYDIR));
		array_unshift($options, " ");

		$value = array_shift($data);

		return in_array($value, $options);
	}

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
			'fields' => '',
			'order' => ''
		),
	);

/**
 * Blocks model object (AccessCountersBlock)
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @var     null
 */
	private $__AccessCountersBlock = null;

/**
 * frames model object (AccessCountersFrame)
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @var     null
 */
	private $__AccessCountersFrame = null;

/**
 * get default data
 *
 * @param int $blockId blocks.id
 * @param int $langId languages.id
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @return  array
 */
	public function getDefaultData($blockId, $langId) {
		$data[$this->name] = array(
			'id' => 0,
			'block_id' => $blockId,
			'language_id' => $langId,
			'status_id' => 0,
			'is_original' => true,
			'show_number_image' => '',
			'show_digit_number' => Configure::read('AccessCounters.DefalutDigitNumber'),
			'show_format' => 'COUNTER ' . Configure::read('AccessCounters.NumberImageTag'),
		);

		$showFormats = explode(Configure::read('AccessCounters.NumberImageTag'), $data[$this->name]['show_format']);
		$data[$this->name]['show_prefix_format'] = $showFormats[0];
		$data[$this->name]['show_suffix_format'] = (isset($showFormats[1]) ? $showFormats[1] : '');

		return $data;
	}

/**
 * get default data(show_digit_number)
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @return  array
 */
	public function getDefaultDigitNumberData() {
		$options = array();
		$maxDigitNumber = intval(Configure::read('AccessCounters.MaxDigitNumber'));
		for ($i = 1; $i <= $maxDigitNumber; $i++) {
			$options[$i] = $i;
		}

		return $options;
	}

/**
 * get default data(show_number_image)
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @return  array
 */
	public function getDefaultNumberImageData() {
		$imgPath = ROOT . DS . 'app' . DS . 'Plugin' . DS . $this->plugin . DS . WEBROOT_DIR . DS . 'img' . DS . '*';
		$options = array_map('basename', glob($imgPath, GLOB_ONLYDIR));

		array_unshift($options, " ");

		return array_combine($options, $options);
	}

/**
 * get latest data
 *
 * @param int $blockId blocks.id
 * @param int $langId languages.id
 * @param null $isSetting セッティングモードの状態 trueならon
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @return  array
 */
	public function getData($blockId, $langId, $isSetting = null) {
		if (! $isSetting) {
			return $this->getPublishData($blockId, $langId);
		}

		$data = $this->find('first', array(
			'conditions' => array(
				'AccessCountersFormat.block_id' => $blockId,
				'AccessCountersFormat.language_id' => $langId,
			),
			'order' => 'AccessCountersFormat.id DESC',
		));

		if ($data) {
			$tag = Configure::read('AccessCounters.NumberImageTag');
			$showFormats = explode($tag, $data[$this->name]['show_format']);
			$data[$this->name]['show_prefix_format'] = $showFormats[0];
			$data[$this->name]['show_suffix_format'] = (isset($showFormats[1]) ? $showFormats[1] : '');
		}

		return $data;
	}

/**
 * get publish latest data
 *
 * @param int $blockId blocks.id
 * @param int $langId languages.id
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @return  array
 */
	public function getPublishData($blockId, $langId) {
		$data = $this->find('first', array(
			'conditions' => array(
				'AccessCountersFormat.block_id' => $blockId,
				'AccessCountersFormat.language_id' => $langId,
				'AccessCountersFormat.status_id' => Configure::read('AccessCounters.Status.Publish'),
			),
			'order' => 'AccessCountersFormat.id DESC'
		));

		if ($data) {
			$showFormats = explode(Configure::read('AccessCounters.NumberImageTag'), $data[$this->name]['show_format']);
			$data[$this->name]['show_prefix_format'] = $showFormats[0];
			$data[$this->name]['show_suffix_format'] = (isset($showFormats[1]) ? $showFormats[1] : '');
		}

		return $data;
	}

/**
 * get publish status
 *
 * @param int $blockId blocks.id
 * @param int $langId languages.id
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @return  int
 */
	public function getIsPublished($blockId, $langId) {
		return $this->find('count', array(
			'conditions' => array(
				'AccessCountersFormat.block_id' => $blockId,
				'AccessCountersFormat.language_id' => $langId,
				'AccessCountersFormat.status_id' => Configure::read('AccessCounters.Status.Publish'),
			)
		)) > 0 ? true : false;
	}

/**
 * save
 *
 * @param array $data post data
 * @param int $frameId Frame.id
 * @param int $userId  users.id
 * @param int $roomId  rooms.id
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @return  mixed null 失敗  array 成功
 */
	public function saveData($data, $frameId, $userId, $roomId) {
		//Modelセット
		$this->__AccessCountersFrame = Classregistry::init("AccessCounters.AccessCountersFrame");
		$this->__AccessCountersBlock = Classregistry::init("AccessCounters.AccessCountersBlock");
		$this->__AccessCountersCount = Classregistry::init("AccessCounters.AccessCountersCount");

		if (! $frameId || ! $userId || ! $roomId) {
			return null;
		}

		//フレーム取得
		$frame = $this->__getFrame($frameId, $userId, $roomId);
		if (! $frame) {
			return null;
		}

		//ブロックIDセット
		$blockId = $frame['AccessCountersFrame']['block_id'];

		//status_idの取得
		$statusId = $this->__getStatusId($data);

		//本体を取得する
		$accessCounter = $this->AccessCounter->findByBlockId($blockId);
		if (! $accessCounter) {
			//なければ作成
			$accessCounter = $this->__createAccessCounter($blockId, $data[$this->name]['language_id'], $userId);
		}

		//登録情報をつくる
		$insertData = array();
		$insertData[$this->name]['access_counter_id'] = $accessCounter['AccessCounter']['id'];
		$insertData[$this->name]['block_id'] = $blockId;
		$insertData[$this->name]['create_user_id'] = $userId;
		$insertData[$this->name]['language_id'] = $data[$this->name]['language_id'];
		$insertData[$this->name]['status_id'] = $statusId;
		$insertData[$this->name]['is_original'] = 1;
		$insertData[$this->name]['show_number_image'] = $data[$this->name]['show_number_image'];
		$insertData[$this->name]['show_digit_number'] = $data[$this->name]['show_digit_number'];
		$insertData[$this->name]['show_format'] = $data[$this->name]['show_prefix_format'] .
													Configure::read('AccessCounters.NumberImageTag') .
													$data[$this->name]['show_suffix_format'];

		//保存結果を返す
		$rtn = $this->save($insertData);

		return $rtn;
	}

/**
 * get frame data
 *
 * @param int $frameId frames.id
 * @param int $userId  users.id
 * @param int $roomId  rooms.id
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @return  mixed null error, array Frame
 */
	private function __getFrame($frameId, $userId, $roomId) {
		//フレームを取得
		$frame = $this->__AccessCountersFrame->findById($frameId);
		if (! $frame) {
			//存在しないfrale
			return null;
		}

		//フレームIDのデータを取得する。
		$blockId = $frame['AccessCountersFrame']['block_id'];

		if (! $blockId) {
			$block = array();
			$block['AccessCountersBlock']['room_id'] = $roomId;
			$block['AccessCountersBlock']['created_user_id'] = $userId;
			$block = $this->__AccessCountersBlock->save($block);

			//blockIdをframeに格納
			$frame['AccessCountersFrame']['block_id'] = $block['AccessCountersBlock']['id'];
			$frame = $this->__AccessCountersFrame->save($frame);
		}
		return $frame;
	}

/**
 * get status_id
 *
 * @param array $data post data
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @return  int
 */
	private function __getStatusId($data) {
		$statusId = null;
		$statuses = Configure::read('AccessCounters.Status');

		$status = $data[$this->name]['status'];
		if (isset($statuses[$status])) {
			$statusId = $statuses[$status];
		}
		return intval($statusId);
	}

/**
 * create AccessCounter
 *
 * @param int $blockId blocks.id
 * @param int $langId languages.id
 * @param int $userId  users.id
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @return  int
 */
	private function __createAccessCounter($blockId, $langId, $userId) {
		//AccessCounterデータ作成
		$data = array();
		$data['AccessCounter']['block_id'] = $blockId;
		$data['AccessCounter']['create_user_id'] = $userId;
		$accessCounter = $this->AccessCounter->save($data);

		//AccessCountersCountデータ作成
		$data = array();
		$data['AccessCountersCount']['access_counter_id'] = $accessCounter['AccessCounter']['id'];
		$data['AccessCountersCount']['block_id'] = $blockId;
		$data['AccessCountersCount']['language_id'] = $langId;
		$data['AccessCountersCount']['created_user_id'] = $userId;
		$data['AccessCountersCount']['modified_user_id'] = $userId;

		$this->__AccessCountersCount->save($data);

		return $accessCounter;
	}

}
