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

<?php echo $this->Html->script('/access_counters/js/access_counters.js'); ?>

<div class="modal-body"
	ng-controller="AccessCounterFrameSettings"
	ng-init="initialize(<?php echo h(json_encode(array(
		'frameId' => $frameId,
		'counterFrameSetting' => $accessCounterFrameSetting,
		'currentDisplayTypeName' => AccessCounterFrameSetting::$displayTypes[$accessCounterFrameSetting['displayType']]
	))); ?>)">

	<?php echo $this->element('NetCommons.setting_tabs', $settingTabs); ?>

	<div class="tab-content">
		<?php echo $this->element('Blocks.setting_tabs', $blockSettingTabs); ?>

		<?php echo $this->element('Blocks.edit_form', array(
				'controller' => 'AccessCounter',
				'action' => h($this->request->params['action']) . '/' . $frameId . '/' . $blockId,
				'callback' => 'AccessCounters.AccessCounters/edit_form',
				'cancelUrl' => '/access_counters/access_counter_blocks/index/' . $frameId
			)); ?>

		<?php if ($this->request->params['action'] === 'edit') : ?>
			<?php echo $this->element('Blocks.delete_form', array(
					'controller' => 'AccessCounter',
					'action' => 'delete/' . $frameId . '/' . $blockId,
					'callback' => 'AccessCounters.AccessCounters/delete_form'
				)); ?>
		<?php endif; ?>
	</div>
</div>
