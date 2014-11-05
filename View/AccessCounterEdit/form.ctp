<?php
/**
 * AccessCounter edit view form template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

echo $this->Form->create(null);

echo $this->Form->input('AccessCounter.is_started', array(
			'type' => 'checkbox',
			'checked' => $counter['AccessCounter']['is_started']
		)
	);

echo $this->Form->input('AccessCounter.count_start', array(
			'type' => 'number',
		)
	);

echo $this->Form->input('AccessCounterFrameSetting.id', array(
			'type' => 'hidden',
			'value' => (int)$counter['AccessCounterFrameSetting']['id']
		)
	);

echo $this->Form->input('AccessCounterFrameSetting.display_type', array(
			'type' => 'number'
		)
	);

echo $this->Form->input('AccessCounterFrameSetting.display_digit', array(
			'type' => 'select',
			'options' => AccessCounter::getDisplayDigitOptions(),
		)
	);

echo $this->Form->input('Frame.id', array(
			'type' => 'hidden',
			'value' => (int)$frameId,
			'ng-model' => 'edit.data.Frame.id'
		)
	);

echo $this->Form->end();
