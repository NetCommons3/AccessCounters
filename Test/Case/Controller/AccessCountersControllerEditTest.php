<?php
/**
 * AccessCounteController->edit() Test Case
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
 * AccessCounteController->edit() Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\AccessCounters\Test\Case\Controller
 */
class AccessCountersControllerEditTest extends AccessCountersControllerTestBase {

/**
 * testIndex method
 *
 * @return void
 */
	public function testEditGet() {
		//RolesControllerTest::login($this);
		//
		//$frameId = '161';
		//$blockId = '161';
		//$this->testAction('/access_counters/access_counters/edit/' . $frameId . '/' . $blockId,
		//	array(
		//		'method' => 'get'
		//	)
		//);
		//
		//AuthGeneralControllerTest::logout($this);
	}

/**
 * testEdit method
 *
 * @return void
 */
	public function testEditPost() {
		//RolesControllerTest::login($this);
		//
		//$frameId = '161';
		//$blockId = '161';
		//$postData = array(
		//	'AccessCounter' => array(
		//		'block_key' => 'block_' . $blockId,
		//		'count_start' => 0,
		//	),
		//	'AccessCounterFrameSetting' => array(
		//		'id' => 1,
		//		'display_digit' => 5,
		//		'display_type' => 3,
		//	),
		//	'Frame' => array(
		//		'id' => $frameId,
		//		'key' => '',
		//	),
		//	'Block' => array(
		//		'id' => $blockId,
		//		'key' => 'block_' . $blockId,
		//		'public_type' => '1'
		//	)
		//);
		//
		//$this->testAction('/access_counters/access_counters/edit/' . $frameId . '/' . $blockId . '.json',
		//	array(
		//		'method' => 'post',
		//		'data' => $postData
		//	)
		//);
		//
		//AuthGeneralControllerTest::logout($this);
	}

/**
 * testEditErrorByRequestGet method
 *
 * @return void
 */
	public function testEditErrorByRequestGet() {
		//$this->setExpectedException('BadRequestException');
		//
		//RolesControllerTest::login($this);
		//
		//$this->testAction('/access_counters/access_counters/edit/1',
		//	array(
		//		'method' => 'get'
		//	)
		//);
		//
		//AuthGeneralControllerTest::logout($this);
	}

/**
 * testBeforeFilterByNoSetFrameId method
 *
 * @return void
 */
	public function testBeforeFilterByNoSetFrameId() {
		//$this->setExpectedException('ForbiddenException');
		//$this->testAction('/access_counters/access_counters/edit', array('method' => 'get'));
	}

/**
 * testBeforeFilterErrorByNoEditable method
 *
 * @return void
 */
	public function testBeforeFilterErrorByNoEditable() {
		//$this->setExpectedException('ForbiddenException');
		//$this->testAction('/access_counters/access_counters/edit/1', array('method' => 'get'));
	}

}
