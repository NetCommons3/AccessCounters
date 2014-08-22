<?php
/**
 * AccessCounters All Test Case
 *
 * @copyright    Copyright 2014, NetCommons Project
 * @link          http://www.netcommons.org NetCommons Project
 * @author        Noriko Arai <arai@nii.ac.jp>
 * @author        Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package       app.Plugin.AccessCounters.Test.Case
 * @license       http://www.netcommons.org/license.txt NetCommons License
 */

/**
 * AccessCounters All Test Case
 *
 * @author        Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package       app.Plugin.AccessCounters.Test.Case
 * @codeCoverageIgnore
 */
class AllAccessCountersTest extends CakeTestSuite {

/**
 * All test suite
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return   CakeTestSuite
 */
	public static function suite() {
		$plugin = preg_replace('/^All([\w]+)Test$/', '$1', __CLASS__);

		$suite = new CakeTestSuite(sprintf('All %s Plugin tests', $plugin));
		$suite->addTestDirectoryRecursive(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . DS . 'Model');
		$suite->addTestDirectoryRecursive(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . DS . 'Controller');
		$suite->addTestDirectoryRecursive(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . DS . 'View');

		return $suite;
	}
}
