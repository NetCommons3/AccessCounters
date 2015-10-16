<?php
/**
 * AccessCounterBlocksController Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AccessCounterBlocksController', 'AccessCounters.Controller');
App::uses('BlocksControllerTest', 'Blocks.TestSuite');

/**
 * AccessCounterBlocksController Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\AccessCounters\Test\Case\Controller
 */
class AccessCounterBlocksControllerIndexTest extends BlocksControllerTest {

/**
 * Plugin name
 *
 * @var array
 */
	public $plugin = 'access_counters';

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.access_counters.access_counter',
		'plugin.access_counters.access_counter_frame_setting',
	);

/**
 * Edit controller name
 *
 * @var string
 */
 	protected $_editController = 'access_counters';

}
