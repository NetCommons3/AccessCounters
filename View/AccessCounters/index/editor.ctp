<?php
/**
 * index/editor template
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 * @package     app.Plugin.AccessCounters.View.AccessCounters.index
 */

//本文の表示
echo $this->element("AccessCounters.index/access_counter_data");

//ラベルの表示
echo $this->element('AccessCounters.index/status_label', array('showPublish' => false));
