<?php
/**
 * AccessCountersController Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AccessCountersController', 'AccessCounters.Controller');
App::uses('AccessCountersControllerTestBase', 'AccessCounters.Test/Case/Controller');

/**
 * AccessCountersController Test Case
 *
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package NetCommons\AccessCounters\Test\Case\Controller
 */
class AccessCountersControllerViewTest extends AccessCountersControllerTestBase {

/**
 * testIndex method
 *
 * @return void
 */
	public function testView() {
		$frameId = '161';
		$this->testAction('/access_counters/access_counters/view/' . $frameId,
			array(
				'method' => 'get',
				'return' => 'view',
			)
		);

		$expected = 'primary';
		$this->assertTextContains($expected, $this->view);
	}

/**
 * testViewNotStarted method
 *
 * @return void
 */
	public function testViewNotStarted() {
		$frameId = '162';
		$this->testAction('/access_counters/access_counters/view/' . $frameId,
			array(
				'method' => 'get',
				'return' => 'view',
			)
		);

		$expected = 'primary';
		$this->assertTextContains($expected, $this->view);
	}
}
