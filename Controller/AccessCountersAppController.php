<?php
/**
 * AccessCountersApp Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * AccessCountersApp Controller
 *
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package NetCommons\AccessCounters\Controller
 */
class AccessCountersAppController extends AppController {

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'Security',
		'NetCommons.NetCommonsFrame',
	);

/**
 * use models
 *
 * @var array
 */
	public $uses = array(
		'AccessCounters.AccessCounter',
		'Blocks.Block',
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$results = $this->camelizeKeyRecursive(['current' => $this->current]);
		$this->set($results);
	}

/**
 * initTabs
 *
 * @param string $mainActiveTab Main active tab
 * @param string $blockActiveTab Block active tab
 * @return void
 */
	public function initTabs($mainActiveTab, $blockActiveTab) {
		if (isset($this->params['pass'][1])) {
			$blockId = (int)$this->params['pass'][1];
		} else {
			$blockId = null;
		}

		//タブの設定
		$settingTabs = array(
			'tabs' => array(
				'block_index' => array(
					'url' => array(
						'plugin' => $this->params['plugin'],
						'controller' => 'blocks',
						'action' => 'index',
						$this->viewVars['frameId'],
					)
				),
				'frame_settings' => array(
					'url' => array(
						'plugin' => $this->params['plugin'],
						'controller' => 'access_counter_frame_settings',
						'action' => 'edit',
						$this->viewVars['frameId'],
					)
				),
			),
			'active' => $mainActiveTab
		);
		$this->set('settingTabs', $settingTabs);

		$blockSettingTabs = array(
			'tabs' => array(
				'block_settings' => array(
					'url' => array(
						'plugin' => $this->params['plugin'],
						'controller' => 'access_counters',
						'action' => $this->params['action'],
						$this->viewVars['frameId'],
						$blockId
					)
				),
			),
			'active' => $blockActiveTab
		);
		$this->set('blockSettingTabs', $blockSettingTabs);
	}

/**
 * initAccessCounter
 *
 * @param array $contains Optional result sets
 * @return bool True on success, False on failure
 */
	public function initAccessCounter($contains = []) {
		if (in_array('block', $contains, true)) {
			if (! $block = $this->Block->find('first', array(
				'recursive' => -1,
				'conditions' => array(
					'Block.id' => $this->viewVars['blockId'],
					'Block.room_id' => $this->viewVars['roomId'],
				)
			))) {
				$this->throwBadRequest();
				return false;
			}
			$block = $this->camelizeKeyRecursive($block);
			$this->set($block);
			$this->set('blockId', (int)$block['block']['id']);
			$this->set('blockKey', $block['block']['key']);
		}

		if (! $counterFrameSetting = $this->AccessCounterFrameSetting->getAccessCounterFrameSetting($this->viewVars['frameKey'])) {
			$counterFrameSetting = $this->AccessCounterFrameSetting->create(array(
				'id' => null,
				'display_type' => 1,
				'frame_key' => $this->viewVars['frameKey'],
			));
		}
		$counterFrameSetting = $this->camelizeKeyRecursive($counterFrameSetting);
		$this->set($counterFrameSetting);

		$this->set('userId', (int)$this->Auth->user('id'));

		return true;
	}

}
