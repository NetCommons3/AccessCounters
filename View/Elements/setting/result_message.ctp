<?php
/**
 * setting/result_message template elements
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 * @since       NetCommons 3.0.0.0
 * @package     app.Plugin.AccessCounters.View.Elements.setting
 */
?>
<p>
	<div class="alert alert-danger hidden" id="access-counters-message-area-<?php echo intval($frameId); ?>">
		<span class="pull-right" ng-click="closeResultMess(<?php echo intval($frameId); ?>)">
			<span class="glyphicon glyphicon-remove"> </span>
		</span>
		<span class="message"> </span>
	</div>
</p>
