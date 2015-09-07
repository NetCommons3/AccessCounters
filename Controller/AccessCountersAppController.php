<?php
/**
 * AccessCountersApp Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * AccessCountersApp Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\AccessCounters\Controller
 */
class AccessCountersAppController extends AppController {

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'Pages.PageLayout',
		'Security',
	);

/**
 * use models
 *
 * @var array
 */
	public $uses = array(
		'AccessCounters.AccessCounter',
	);

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
						'controller' => 'access_counter_blocks',
						'action' => 'index',
						Current::read('Frame.id'),
					)
				),
				'frame_settings' => array(
					'url' => array(
						'plugin' => $this->params['plugin'],
						'controller' => 'access_counter_frame_settings',
						'action' => 'edit',
						Current::read('Frame.id'),
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
						Current::read('Frame.id'),
						$blockId
					)
				),
			),
			'active' => $blockActiveTab
		);
		$this->set('blockSettingTabs', $blockSettingTabs);
	}

}
