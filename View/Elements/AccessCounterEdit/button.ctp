<?php
/**
 * AccessCounter edit button element template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<p class="text-center">
	<button type="button" class="btn btn-default" ng-click="cancel()">
		<span class="glyphicon glyphicon-remove small"></span>
		<?php echo __d('net_commons', 'Cancel'); ?>
	</button>
	<button type="button" class="btn btn-primary" ng-click="save()" ng-disabled="accessCounterEdit.$invalid">
		<?php echo __d('net_commons', 'OK'); ?>
	</button>
</p>
