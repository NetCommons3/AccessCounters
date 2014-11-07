<?php
/**
 * AccessCounter edit tab_header element template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<button class="close" type="button"
		tooltip="<?php echo __d('net_commons', 'Close'); ?>"
		ng-click="cancel()">

	<span class="glyphicon glyphicon-remove small"></span>
</button>
<ul class="nav nav-pills">
	<li class="active">
		<a href="#" ng-click="showManage();">
			<?php echo __d('access_counters', 'Counter Edit'); ?>
		</a>
	</li>
</ul>
