<?php
/**
 * AccessCounter view template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @author Kazunori Sakamoto <exkazuu@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

echo $this->NetCommonsHtml->script('/access_counters/js/access_counters.js');
?>

<div ng-controller="AccessCounters" ng-init="initialize(<?php echo h(Current::read('Frame.id')) . ', ' . h($counterText); ?>)">
	<span class="label label-<?php echo $displayType; ?>" ng-repeat="counterChar in counterText track by $index">
		{{counterChar}}
	</span>
</div>
