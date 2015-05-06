<?php
/**
 * BbsSettings edit template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->Html->script('/access_counters/js/access_counters.js', false); ?>

<div class="modal-body"
	ng-controller="AccessCounterFrameSettings"
	ng-init="initialize(<?php echo h(json_encode(array(
		'frameId' => $frameId,
		'counterFrameSetting' => $accessCounterFrameSetting,
		'currentDisplayTypeName' => AccessCounterFrameSetting::$displayTypes[$accessCounterFrameSetting['displayType']]
	))); ?>)">

	<?php echo $this->element('NetCommons.setting_tabs', $settingTabs); ?>

	<div class="tab-content">
		<?php echo $this->element('Blocks.edit_form', array(
				'controller' => 'AccessCounterFrameSettings',
				'action' => 'edit' . '/' . $frameId,
				'callback' => 'AccessCounters.AccessCounterFrameSettings/edit_form',
				'cancelUrl' => '/' . $cancelUrl,
			)); ?>
	</div>
</div>
