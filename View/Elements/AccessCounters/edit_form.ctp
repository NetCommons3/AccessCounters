<?php
/**
 * AccessCounters edit form template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->element('Blocks.form_hidden'); ?>

<?php echo $this->NetCommonsForm->hidden('AccessCounter.id'); ?>

<?php echo $this->NetCommonsForm->hidden('AccessCounter.block_key'); ?>

<?php echo $this->NetCommonsForm->input('BlocksLanguage.name', array(
		'type' => 'text',
		'label' => __d('access_counters', 'Access counter name'),
		'required' => true
	)); ?>

<?php echo $this->NetCommonsForm->input('AccessCounter.count_start', array(
		'type' => 'number',
		'label' => __d('access_counters', 'Starting Value'),
		'readonly' => (bool)$this->data['AccessCounter']['id'],
		'max' => AccessCounter::MAX_VALUE
	)); ?>

<?php echo $this->element('Blocks.public_type');
