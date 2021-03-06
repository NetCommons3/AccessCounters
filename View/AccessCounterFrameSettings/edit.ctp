<?php
/**
 * AccessCounterFrameSettings edit template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

echo $this->NetCommonsHtml->script('/access_counters/js/access_counters.js');

if (isset($this->data['AccessCounterFrameSetting'])) {
	$camelizeData = NetCommonsAppController::camelizeKeyRecursive(array(
		'frameId' => $this->data['Frame']['id'],
		'counterFrameSetting' => $this->data['AccessCounterFrameSetting'],
		'currentDisplayTypeName' => AccessCounterFrameSetting::$displayTypes[$this->data['AccessCounterFrameSetting']['display_type']]
	));
} else {
	$camelizeData = array(
		'frameId' => $this->data['Frame']['id'],
		'counterFrameSetting' => array(),
		'currentDisplayTypeName' => ''
	);
}
?>

<article class="block-setting-body"
	ng-controller="AccessCounterFrameSettings"
	ng-init="initialize(<?php echo h(json_encode($camelizeData)); ?>)">

	<?php echo $this->BlockTabs->main(BlockTabsHelper::MAIN_TAB_FRAME_SETTING); ?>

	<div class="tab-content">
		<?php echo $this->element('Blocks.edit_form', array(
				'model' => 'AccessCounterFrameSetting',
				'callback' => 'AccessCounters.AccessCounterFrameSettings/edit_form',
				'cancelUrl' => NetCommonsUrl::backToPageUrl(true),
			)); ?>
	</div>
</article>
