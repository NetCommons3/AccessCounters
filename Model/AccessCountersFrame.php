<?php
/**
 * AccessCountersFrame Model
 *
 * @property AccessCounter $AccessCounter
 * @property Frame $Frame
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
 * AccessCountersFrame Model
 *
 * @property AccessCounter $AccessCounter
 * @property Frame $Frame
 *
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package     app.Plugin.AccessCounters.Model
 */
class AccessCountersFrame extends AppModel {

/**
 * table name
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @var     string
 */
	public $useTable = 'frames';

/**
 * model name
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @var     string
 */
	public $name = 'AccessCountersFrame';

/**
 * Get blockId from frameId
 *
 * @param int $frameId frames.id
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return  int blocks.id
 */
	public function getBlockId($frameId) {
		if (! $frameId) {
			return null;
		}
		$frameId = intval($frameId);

		$frame = $this->findById($frameId);
		if ($frame && $frame[$this->name]['block_id']) {
			return $frame[$this->name]['block_id'];
		}

		return null;
	}
}