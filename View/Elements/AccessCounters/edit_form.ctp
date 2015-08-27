<?php
/**
 * AccessCounterBlocks edit template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->Form->hidden('Frame.id'); ?>

<?php echo $this->Form->hidden('Block.id'); ?>

<?php echo $this->Form->hidden('Block.key'); ?>

<?php echo $this->Form->hidden('Block.language_id'); ?>

<?php echo $this->Form->hidden('Block.room_id'); ?>

<?php echo $this->Form->hidden('Block.plugin_key'); ?>

<?php echo $this->Form->hidden('AccessCounter.id'); ?>

<?php echo $this->Form->hidden('AccessCounter.block_key'); ?>

<div class="form-group">
	<?php echo $this->Form->input(
			'Block.name', array(
				'type' => 'text',
				'label' => __d('access_counters', 'Access counter name') . $this->element('NetCommons.required'),
				'error' => false,
				'class' => 'form-control',
				'autofocus' => true,
//				'value' => (isset($block['name']) ? $block['name'] : '')
			)
		); ?>

	<?php echo $this->element(
		'NetCommons.errors', [
			'errors' => $this->validationErrors,
			'model' => 'Block',
			'field' => 'name',
		]); ?>
</div>

<?php if (! PageLayoutHelper::$frame['blockId']) : ?>
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
//			'value' => $accessCounter['countStart'],
			'readonly' => (bool)$this->data['AccessCounter']['id']
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
