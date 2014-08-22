<?php
/**
 * AccessCountersBlock Model
 *
 * @property AccessCounter $AccessCounter
 * @property Frame $Frame
 * @property Block $Block
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 * @package     app.Plugin.AccessCounters.Model
 */

App::uses('AppModel', 'Model');

/**
 * AccessCountersBlock Model
 *
 * @property AccessCounter $AccessCounter
 * @property Frame $Frame
 * @property Block $Block
 *
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package     app.Plugin.AccessCounters.Model
 */
class AccessCountersBlock extends AppModel {

/**
 * Use database config
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @var     string
 */
	public $useDbConfig = 'master';

/**
 * use table
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @var     bool
 */
	public $useTable = 'blocks';

/**
 * model name
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @var     string
 */
	public $name = "AccessCountersBlock";

}