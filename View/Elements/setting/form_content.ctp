<?php
/**
 * setting/form_content template elements
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 * @since       NetCommons 3.0.0.0
 * @package     app.Plugin.AccessCounters.View.Elements.setting
 */
?>

<div class='form-group'>
	<?php
		//表示する桁数
		echo $this->Form->label('AccessCountersFormat.show_digit_number', __('表示する桁数'));

		echo $this->Form->input('AccessCountersFormat.show_digit_number', array(
					'label' => false,
					'type' => 'select',
					'options' => $digitNumberOptions,
					'selected' => $item['AccessCountersFormat']['show_digit_number'],
					'class' => 'form-control',
				)
			);
	?>
</div>

<div class='form-group'>
	<?php
		//画像選択
		echo $this->Form->label('AccessCountersFormat.show_number_image', __('画像選択'));

		echo $this->Form->input('AccessCountersFormat.show_number_image', array(
					'label' => false,
					'type' => 'select',
					'options' => $numberImageOptions,
					'selected' => h($item['AccessCountersFormat']['show_number_image']),
					'class' => 'form-control',
				)
			);
	?>
</div>

<div class='form-group'>
	<?php
		//文字(前)
		echo $this->Form->label('AccessCountersFormat.show_prefix_format', __('文字(前)'));

		echo $this->Form->input('AccessCountersFormat.show_prefix_format', array(
					'label' => false,
					'type' => 'textarea',
					'rows' => 2,
					'value' => h($item['AccessCountersFormat']['show_prefix_format']),
					'class' => 'form-control',
				)
			);
	?>
</div>

<div class='form-group'>
	<?php
		//文字(後)
		echo $this->Form->label('AccessCountersFormat.show_suffix_format', __('文字(後)'));

		echo $this->Form->input('AccessCountersFormat.show_suffix_format', array(
					'label' => false,
					'type' => 'textarea',
					'rows' => 2,
					'value' => h($item['AccessCountersFormat']['show_suffix_format']),
					'class' => 'form-control',
				)
			);
	?>
</div>
