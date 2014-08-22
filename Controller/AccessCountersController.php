<?php
/**
 * AccessCounters Controller
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 * @package     app.Plugin.AccessCounters.Controller
 */

App::uses('AccessCountersAppController', 'AccessCounters.Controller');

/**
 * AccessCounters Controller
 *
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package     app.Plugin.AccessCounters.Controller
 */
class AccessCountersController extends AccessCountersAppController {

/**
 * name property
 *
 * @author    Shohei Nakajima <nakajimashouhei@gmail.com>
 * @var       string
 */
	public $name = 'AccessCountersController';

/**
 * has published
 *
 * @author    Shohei Nakajima <nakajimashouhei@gmail.com>
 * @var       bool
 */
	private $__hasPublished = false;

/**
 * Model name
 *
 * @author    Shohei Nakajima <nakajimashouhei@gmail.com>
 * @var       array
 */
	public $uses = array(
		'AccessCounters.AccessCounter',
		'AccessCounters.AccessCountersFormat',
		'AccessCounters.AccessCountersFrame', //Frames
		'AccessCounters.AccessCountersCount',
	);

/**
 * beforeFilter
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return   void
 */
	public function beforeFilter() {
		parent::beforeFilter();

		$this->Auth->allow();

		//blockIdの初期値セット
		$this->set('blockId', 0);

		//セッティングモードの状態
		$this->_setSetting();
		//ユーザIDの設定
		$this->_setUserId();
		//編集権限のチェックと設定値の格納
		$this->_checkEditor();
		//公開権限のチェックと設定値の格納
		$this->_checkPublisher();
		//著者かどうかの確認と設定値の格納
		$this->_checkAuthor();
		//Ajax判定と設定値の格納
		$this->_checkAjax();
		//言語の設定
		$this->_setLang();
		//ルームIDの設定
		$this->_setRoomtId();
	}

/**
 * index
 *
 * @param int $frameId frames.id
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return   CakeResponse
 */
	public function index($frameId = 0) {
		//変数の初期値
		$frameId = intval($frameId);

		//レイアウトの切り替え（Ajaxと通常のときの切り替え）
		$this->_setLayout();

		//blockIdの取得
		$blockId = $this->AccessCountersFrame->getBlockId($frameId);

		//ブロックが設定されておらず、セッティングモードなし
		if (! $blockId && ! $this->isSetting) {
			return $this->render('AccessCounters/notice');
		}

		//ブロックに一度でも公開された場合カウントアップする
		$this->__setAccessCountUp($blockId);

		//ログインなし もしくは、編集権限および公開権限なし
		if (! $this->isLogin || ! $this->isEditor && ! $this->isPublisher) {
			if (! $blockId) {
				//セッティングモードなし
				return $this->render('AccessCounters/notice');
			} else {
				//セッティングモードあり
				return $this->__indexNologin($frameId, $blockId);
			}
		}

		//セッティングモードOffであり、編集権限があり場合
		if (! $this->isSetting) {
			return $this->__indexNoSetting($frameId, $blockId);
		}

		//編集権限もしくは公開権限あり
		return $this->__indexEditor($frameId, $blockId);
	}

/**
 * index (Setting off, Edit on)
 *
 * @param int $frameId frames.id
 * @param int $blockId blocks.id
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return   CakeResponse
 */
	private function __indexNoSetting($frameId, $blockId) {
		//フォーマットデータの取得＆セット(パートで表示できる内容)
		$data = $this->AccessCountersFormat->getData($blockId, $this->langId, true);
		if (! $data) {
			return $this->render('AccessCounters/notice');
		}
		$this->set('item', $data);

		//アクセスカウンターの件数セット
		$count = $this->AccessCountersCount->getAccessCount($blockId, $this->langId);
		$this->__setDisplayAccessCount($count, $data);

		//IDセット
		$this->set('frameId', $frameId);
		$this->set('blockId', $blockId);

		//Viewの指定
		return $this->render('AccessCounters/index/editor');
	}

/**
 * index (no login)
 *
 * @param int $frameId frames.id
 * @param int $blockId blocks.id
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return   CakeResponse
 */
	private function __indexNologin($frameId, $blockId) {
		//フォーマットデータの取得＆セット(公開のみ)
		$data = $this->AccessCountersFormat->getPublishData($blockId, $this->langId);
		if (! $data) {
			return $this->render('AccessCounters/notice');
		}
		$this->set('item', $data);

		//アクセスカウンターの件数セット
		$count = $this->AccessCountersCount->getAccessCount($blockId, $this->langId);
		$this->__setDisplayAccessCount($count, $data);

		//IDセット
		$this->set('frameId', $frameId);
		$this->set('blockId', $blockId);

		//Viewの指定
		return $this->render('AccessCounters/index/default');
	}

/**
 * index (editor)
 *
 * @param int $frameId frames.id
 * @param int $blockId blocks.id
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return   CakeResponse
 */
	private function __indexEditor($frameId, $blockId) {
		//表示件数の選択肢リストの取得＆セット
		$digitNumberOptions = $this->AccessCountersFormat->getDefaultDigitNumberData();
		$this->set('digitNumberOptions', $digitNumberOptions);

		//表示画像の選択肢リストの取得＆セット
		$numberImageOptions = $this->AccessCountersFormat->getDefaultNumberImageData();
		$this->set('numberImageOptions', $numberImageOptions);

		//フォーマットデータの取得＆セット
		$data = $this->AccessCountersFormat->getData($blockId, $this->langId, true);
		if (! $data) {
			//アクセス件数のセット
			$this->set('accessCount', 0);
			//表示用アクセス件数のセット
			$this->set('showCountContent', '');
			//デフォルトフォーマットデータ取得
			$data = $this->AccessCountersFormat->getDefaultData($blockId, $this->langId);
		} else {
			//アクセスカウンターの件数セット
			$count = $this->AccessCountersCount->getAccessCount($blockId, $this->langId);
			$this->__setDisplayAccessCount($count, $data);
		}
		$this->set('item', $data);

		//IDセット
		$this->set('frameId', $frameId);
		$this->set('blockId', $blockId);

		//Viewの指定
		return $this->render('AccessCounters/setting/index');
	}

/**
 * Is publised
 *
 * @param int $blockId blocks.id
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return   bool
 */
	private function __getPublished($blockId) {
		if (! $blockId) {
			return false;
		}
		return $this->AccessCountersFormat->getIsPublished($blockId, $this->langId);
	}

/**
 * set access count up
 *
 * @param int $blockId blocks.id
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return   void
 */
	private function __setAccessCountUp($blockId) {
		$this->__hasPublished = $this->__getPublished($blockId);
		if (! $this->__hasPublished) {
			return;
		}

		//TODOカウントUPをクッキーで制御する
		$alreadyCountUp = false;
		if (! $alreadyCountUp) {
			$this->AccessCountersCount->saveCountUp($blockId, $this->langId, $this->_userId);
		}
	}

/**
 * Get display access count
 *
 * @param int $count count
 * @param array $format AccessCountersFormat
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return   string
 */
	private function __setDisplayAccessCount($count, $format) {
		//アクセス件数のセット
		$this->set('accessCount', $count);

		//アクセス件数(表示用)のセット
		$showDigitNumber = intval($format['AccessCountersFormat']['show_digit_number']);
		$displayAccessCount = sprintf('%0' . $showDigitNumber . 'd', $count);

		$tag = Configure::read('AccessCounters.NumberImageTag');
		$replace = array($tag => '%s');
		$showFormat = strtr($format['AccessCountersFormat']['show_format'], $replace);

		$imageDir = $format['AccessCountersFormat']['show_number_image'];
		$imageCounter = '';
		for ($i = 0; $i < $showDigitNumber; $i++) {
			$number = substr($displayAccessCount, $i, 1);
			if (trim($imageDir) != '') {
				$imageCounter .= '<img src="/access_counters/img/' . $imageDir . '/' . $number . '.gif" alt="' . $number . '" />';
			} else {
				$imageCounter .= $number;
			}
		}
		$showCountContent = sprintf(nl2br(h($showFormat)), $imageCounter);
		$this->set('showCountContent', $showCountContent);

		return $showCountContent;
	}

/**
 * get edit form
 *
 * @param int $frameId frames.id
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return   CakeResponse
 */
	public function get_edit_form($frameId = 0) {
		$this->layout = false;
		$this->isSetting = true;

		//変数の初期値
		$frameId = intval($frameId);

		//blockIdの取得
		$blockId = $this->AccessCountersFrame->getBlockId($frameId);

		//編集権限もしくは公開権限あり
		if ($this->isEditor || $this->isPublisher) {
			$this->__indexEditor($frameId, $blockId);
			//Viewの指定
			return $this->render('AccessCounters/setting/get_edit_form');
		}

		return $this->render('notice');
	}

/**
 * edit access count format
 *
 * @param int $frameId frames.id
 * @return CakeResponse
 */
	public function edit($frameId = 0) {
		$this->viewClass = 'Json';

		//レイアウトの設定
		$this->_setLayout();

		//POSTチェック
		if (! $this->request->isPost()) {
			//post以外の場合、エラー
			$this->response->statusCode(400);
			return $this->_setSaveResult('ERROR',
					__('Security Error! Unauthorized input.')
				);
		}

		//保存
		$rtn = $this->AccessCountersFormat->saveData(
			$this->data,
			$frameId,
			$this->_userId,
			$this->_roomId
		);
		if ($rtn) {
			//成功結果を返す  TODO現状日本語で表示
			$blockId = $this->data['AccessCountersFormat']['block_id'];
			$langId = $this->data['AccessCountersFormat']['language_id'];
			$count = $this->AccessCountersCount->getAccessCount($blockId, $langId);
			$rtn['showCountContent'] = $this->__setDisplayAccessCount($count, $rtn);
			return $this->_setSaveResult('OK',
					//__('Successfully finished.'),
					__('保存しました。'),
					$rtn
				);
		} else {
			//失敗結果を返す
			$this->response->statusCode(400);
			return $this->_setSaveResult('NG',
					__('Failed to register.')
				);
		}
	}

}
