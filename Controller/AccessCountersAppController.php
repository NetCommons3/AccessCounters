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
		'AccessCounters.AccessCounterFrameSetting',
	);

/**
 * initTabs
 *
 * @param string $mainActiveTab Main active tab
 * @param string $blockActiveTab Block active tab
 * @return void
 */
	public function initTabs($mainActiveTab, $blockActiveTab) {
		//タブの設定
		$settingTabs = array(
			'tabs' => array(
				'block_index' => array(
					'url' => NetCommonsUrl::backToIndexUrl('default_setting_action')
				),
				'frame_settings' => array(
					'url' => NetCommonsUrl::actionUrl(array(
						'controller' => 'access_counter_frame_settings',
						'action' => 'edit',
						'frame_id' => Current::read('Frame.id'),
					))
				),
			),
			'active' => $mainActiveTab
		);
		$this->set('settingTabs', $settingTabs);

		$blockSettingTabs = array(
			'tabs' => array(
				'block_settings' => array(
					'url' => NetCommonsUrl::actionUrl(array(
						'controller' => 'access_counters',
						'action' => $this->params['action'],
						'frame_id' => Current::read('Frame.id'),
						'block_id' => Current::read('Block.id'),
					))
				),
			),
			'active' => $blockActiveTab
		);
		$this->set('blockSettingTabs', $blockSettingTabs);
	}

}
