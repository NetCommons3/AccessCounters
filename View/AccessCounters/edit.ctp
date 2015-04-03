<?php
/**
 * AccessCounter edit view template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->Html->script('/accessCounters/js/access_counters.js'); ?>

<div id="nc-access-counters-<?php echo (int)$frameId; ?>"
	 ng-controller="AccessCounters"
	 ng-init="init(
			<?php echo (int)$frameId; ?>,
			<?php echo h(json_encode($counter)); ?>
		)">

	<?php $this->start('title'); ?>
	<?php echo __d('access_counters', 'plugin_name'); ?>
	<?php $this->end(); ?>

	<div class="modal-header">
		<?php $title = $this->fetch('title'); ?>
		<?php if ($title) : ?>
			<?php echo $title; ?>
		<?php else : ?>
			<br />
		<?php endif; ?>
	</div>

	<div class="modal-body">
		<?php $tabs = $this->fetch('tabs'); ?>
		<?php if ($tabs) : ?>
			<ul class="nav nav-tabs" role="tablist">
				<?php echo $tabs; ?>
			</ul>
			<br />
			<?php $tabId = $this->fetch('tabIndex'); ?>
			<div class="tab-content" ng-init="tab.setTab(<?php echo (int)$tabId; ?>)">
		<?php endif; ?>

		<div>
		<?php echo $this->Form->create('AccessCounter', array(
				'name' => 'form',
				'novalidate' => true,
			)); ?>
			<div class="panel panel-default" >
				<div class="panel-body has-feedback">

					<?php echo $this->element('AccessCounters/edit_form'); ?>

				</div>
				<div class="panel-footer text-center">

					<div class="text-center">
						<button type="button" class="btn btn-default" ng-click="cancel()">
							<span class="glyphicon glyphicon-remove small"></span>
							<?php echo __d('net_commons', 'Cancel'); ?>
						</button>
						<?php echo $this->Form->button(
							__d('net_commons', 'OK'),
							array('class' => 'btn btn-primary')) ?>
					</div>

				</div>
			</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>
