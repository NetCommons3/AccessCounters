<?php
/**
 * AccessCounterBlocksController
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AccessCountersAppController', 'AccessCounters.Controller');

/**
 * AccessCounterBlocksController
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\AccessCounters\Controller
 */
class AccessCounterBlocksController extends AccessCountersAppController {

/**
 * layout
 *
 * @var array
 */
	public $layout = 'NetCommons.setting';

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'NetCommons.Permission' => array(
			//アクセスの権限
			'allow' => array(
				'index,add,edit,delete' => 'block_editable',
			),
		),
		'Paginator',
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		//タブの設定
		$this->initTabs('block_index', 'block_settings');
	}

/**
 * index
 *
 * @return void
 */
	public function index() {
		$this->set('addActionController', 'access_counters');

		$this->Paginator->settings = array(
			'AccessCounter' => array(
				'order' => array('Block.id' => 'desc'),
				'conditions' => $this->AccessCounter->getBlockConditions(),
				//'limit' => 1
			)
		);
		$accessCounters = $this->Paginator->paginate('AccessCounter');
		if (! $accessCounters) {
			$this->view = 'Blocks.Blocks/not_found';
			return;
		}
		$this->set('accessCounters', $accessCounters);

		$this->request->data['Frame'] = Current::read('Frame');
	}

}
