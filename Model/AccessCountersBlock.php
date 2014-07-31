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
 * @since       NetCommons 3.0.0.0
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
 * @since       NetCommons 3.0.0.0
 * @package     app.Plugin.AccessCounters.Model
 */
class AccessCountersBlock extends AppModel {

/**
 * Use database config
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @var     string
 */
	public $useDbConfig = 'master';

/**
 * use table
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @var     bool
 */
	public $useTable = 'blocks';

/**
 * model name
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @since   NetCommons 3.0.0.0
 * @var     string
 */
	public $name = "AccessCountersBlock";

}