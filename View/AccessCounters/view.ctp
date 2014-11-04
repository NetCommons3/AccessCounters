<?php
/**
 * AccessCounter index template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->Html->script('/accessCounters/js/access_counters.js'); ?>
<?php echo $this->Html->css('/accessCounters/css/access_counters.css'); ?>

<div id="nc-access-counters-container-<?php echo (int)$frameId; ?>"
	 ng-controller="AccessCounters"
	 ng-init="initialize(
		<?php echo (int)$frameId; ?>,
		<?php echo h(json_encode($counter)); ?>)">
	<div class="row">
		<?php echo $this->element('AccessCounters/header_button'); ?>
	</div>
	<div class="row text-center">
		<div class="h5">
			<span ng-show="counter.AccessCounter.is_started"
				  class="label label-{{counter.AccessCounterFrameSetting.display_type_label}}"
				  ng-repeat="num in formatCount(
					counter.AccessCounter.count,
					counter.AccessCounterFrameSetting.display_digit) track by $index"
				  ng-bind="num"
				  ng-cloak>
			</span>
		</div>
	</div>
</div>
