<?php
/**
 * FaqBlocksController Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BlocksControllerPaginatorTest', 'Blocks.TestSuite');

/**
 * FaqBlocksController Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\AccessCounter\Test\Case\Controller
 */
class AccessCounterBlocksControllerIndexPaginatorTest extends BlocksControllerPaginatorTest {

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
		'plugin.access_counters.access_counter4paginator',
		'plugin.access_counters.access_counter_frame_setting',
	);

/**
 * Edit controller name
 *
 * @var string
 */
	protected $_editController = 'access_counters';

}
