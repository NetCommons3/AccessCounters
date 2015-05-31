<?php
/**
 * AccessCounteController->add() Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AccessCountersController', 'AccessCounters.Controller');
App::uses('AccessCountersControllerTestBase', 'AccessCounters.Test/Case/Controller');

/**
 * AccessCounteController->add() Test Case
 *
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @package NetCommons\AccessCounters\Test\Case\Controller
 */
class AccessCountersControllerAddTest extends AccessCountersControllerTestBase {

/**
 * A
 *
 * @return void
 */
	public function testAdd() {
		RolesControllerTest::login($this);

		$frameId = '161';
		$postData = array(
			'AccessCounter' => array(
				'block_key' => '',
				'count_start' => 0,
			),
			'AccessCounterFrameSetting' => array(
				'id' => 0,
				'display_digit' => null, // Error
				'display_type' => 0,
			),
			'Frame' => array(
				'id' => '2',
				'key' => '',
			),
			'Block' => array(
				'id' => '',
				'key' => '',
				'public_type' => '1'
			)
		);

		//$this->setExpectedException('ForbiddenException');
		$this->testAction('/access_counters/access_counters/add/' . $frameId . '.json',
			array(
				'method' => 'post',
				'data' => $postData
			)
		);

		AuthGeneralControllerTest::logout($this);
	}
}
