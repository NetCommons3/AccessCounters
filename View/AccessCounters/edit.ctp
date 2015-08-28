<?php
/**
 * AccessCounter edit template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

echo $this->NetCommonsHtml->script('/access_counters/js/access_counters.js');

$camelizeData = NetCommonsAppController::camelizeKeyRecursive(array(
	'frameId' => $frameId,
	'counterFrameSetting' => $this->data['AccessCounterFrameSetting'],
	'currentDisplayTypeName' => AccessCounterFrameSetting::$displayTypes[$this->data['AccessCounterFrameSetting']['display_type']]
));
?>

<div class="modal-body"
	ng-controller="AccessCounterFrameSettings"
	ng-init="initialize(<?php echo h(json_encode($camelizeData)); ?>)">

	<?php echo $this->element('NetCommons.setting_tabs', $settingTabs); ?>

	<div class="tab-content">
		<?php echo $this->element('Blocks.setting_tabs', $blockSettingTabs); ?>

		<?php echo $this->element('Blocks.edit_form', array(
				'model' => 'AccessCounter',
				'callback' => 'AccessCounters.AccessCounters/edit_form',
				'cancelUrl' => '/access_counters/access_counter_blocks/index/' . $frameId
			)); ?>

		<?php if ($this->request->params['action'] === 'edit') : ?>
			<?php echo $this->element('Blocks.delete_form', array(
					'model' => 'AccessCounter',
					'action' => 'delete/' . $frameId . '/' . $blockId,
					'callback' => 'AccessCounters.AccessCounters/delete_form'
				)); ?>
		<?php endif; ?>
	</div>
</div>
