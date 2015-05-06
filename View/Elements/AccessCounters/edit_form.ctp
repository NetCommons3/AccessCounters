<?php
/**
 * Blocks edit template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->Form->hidden('Frame.id', array(
		'value' => $frameId,
	)); ?>

<?php echo $this->Form->hidden('Block.id', array(
		'value' => $block['id'],
	)); ?>

<?php echo $this->Form->hidden('Block.key', array(
		'value' => $block['key'],
	)); ?>

<?php echo $this->Form->hidden('Block.language_id', array(
		'value' => $languageId,
	)); ?>

<?php echo $this->Form->hidden('Block.room_id', array(
		'value' => $roomId,
	)); ?>

<?php echo $this->Form->hidden('Block.plugin_key', array(
		'value' => $this->params['plugin'],
	)); ?>

<?php echo $this->Form->hidden('AccessCounter.id', array(
		'value' => $accessCounter['id'],
	)); ?>

<?php echo $this->Form->hidden('AccessCounter.block_key', array(
		'value' => $block['key'],
	)); ?>

<?php if (! $frame['blockId']) : ?>
	<?php echo $this->element('AccessCounterFrameSettings/edit_form'); ?>
<?php endif; ?>

<div class='form-group'>
	<?php
		echo $this->Form->input('AccessCounter.count_start', array(
			'type' => 'number',
			'label' => __d('access_counters', 'Starting Value'),
			'error' => false,
			'class' => 'form-control',
			'min' => 0,
			'value' => $accessCounter['countStart'],
			'readonly' => (bool)$accessCounter['id']
		));
	?>
	<?php echo $this->element(
		'NetCommons.errors', [
			'errors' => $this->validationErrors,
			'model' => 'AccessCounter',
			'field' => 'count_start',
		]) ?>
</div>

<?php echo $this->element('Blocks.public_type');
