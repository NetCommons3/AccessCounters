<?php
/**
 * setting/get_edit_form template
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 * @package     app.Plugin.AccessCounters.View.AccessCounters.setting
 */

echo $this->Form->create(null);

//編集エリア表示
echo $this->element('AccessCounters.setting/form_content');

//フレームID
echo $this->Form->input('AccessCountersFormat.frame_id', array(
			'type' => 'hidden',
			'value' => h($frameId),
		)
	);

//ブロックID
echo $this->Form->input('AccessCountersFormat.block_id', array(
			'type' => 'hidden',
			'value' => h($item['AccessCountersFormat']['block_id']),
		)
	);

//言語ID
echo $this->Form->input('AccessCountersFormat.language_id', array(
			'type' => 'hidden',
			'value' => h($item['AccessCountersFormat']['language_id']),
		)
	);

//カウンターフォーマットID
echo $this->Form->input('AccessCountersFormat.id', array(
			'type' => 'hidden',
			'value' => h($item['AccessCountersFormat']['id']),
		)
	);

//状態ID
echo $this->Form->input('AccessCountersFormat.status', array(
			'label' => false,
			'type' => 'select',
			'options' => Configure::read('AccessCounters.Status'),
			'div' => array(
				'class' => 'hidden'
			),
		)
	);

echo $this->Form->end();
