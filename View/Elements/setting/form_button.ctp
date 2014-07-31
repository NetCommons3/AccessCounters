<?php
/**
 * setting/form_button template elements
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 * @since       NetCommons 3.0.0.0
 * @package     app.Plugin.AccessCounters.View.Elements.setting
 */

//セッティングモード エディタ用ボタン
//表示非表示初期値制御
$hidden['draft'] = "";
$hidden['preview'] = "";
$hidden['previewClose'] = "hidden";
$hidden['draft'] = "";
$hidden['reject'] = "";
$hidden['publish'] = "";

if (isset($item['AccessCountersFormat']['status_id'])
		&& $item['AccessCountersFormat']['status_id'] == Configure::read('AccessCounters.Status.PublishRequest')) {

	$hidden['draft'] = ' hidden';
	$hidden['reject'] = '';
} else {
	$hidden['draft'] = '';
	$hidden['reject'] = ' hidden';
}
?>

<div
	class="text-center form-group"
	id="access-counters-form-button-area-<?php echo intval($frameId); ?>"
>
	<button
		class="btn btn-default access-counters-editor-button-close"
		ng-click="post('Cancel',
			<?php echo intval($frameId);?>,
			<?php echo intval($blockId);?>)"
	>
		<span class="glyphicon glyphicon-remove"></span>
		<span><?php echo __('閉じる'); ?></span>
	</button>

	<button
		class="btn btn-default access-counters-editor-button-preview"
		id="access-counters-btn-preview-<?php echo intval($frameId);?>"
		ng-click="post('Preview',
			<?php echo intval($frameId);?>,
			<?php echo intval($blockId);?>)"
	>
		<span class="glyphicon glyphicon-file"></span>
		<span><?php echo __('プレビュー'); ?></span>
	</button>

	<button
		class="btn btn-default access-counters-editor-button-preview-close <?php echo $hidden['previewClose']; ?>"
		id="access-counters-btn-close-preview-<?php echo intval($frameId);?>"
		ng-click="post('PreviewClose',
			<?php echo intval($frameId);?>,
			<?php echo intval($blockId);?>)"
	>
		<span class="glyphicon glyphicon-file"></span>
		<span><?php echo __('プレビューを閉じる'); ?></span>
	</button>

	<button
		class="btn btn-default access-counters-editor-button-draft <?php echo $hidden['draft']; ?>"
		id="access-counters-btn-draft-<?php echo intval($frameId);?>"
		ng-click="post('Draft',
			<?php echo intval($frameId);?>,
			<?php echo intval($blockId);?>)"
	>
		<span class="glyphicon glyphicon-pencil"></span>
		<span><?php echo __('下書き'); ?></span>
	</button>

	<button
		class="btn btn-default access-counters-editor-button-reject <?php echo $hidden['reject']; ?>"
		id="access-counters-btn-reject-<?php echo intval($frameId);?>"
		ng-click="post('Reject',
			<?php echo intval($frameId);?>,
			<?php echo intval($blockId);?>)"
	>
		<span class="glyphicon glyphicon-pencil"></span>
		<span><?php echo __('差し戻し'); ?></span>
	</button>

	<button
		class="btn btn-primary access-counters-editor-button-request"
		ng-click="post('PublishRequest',
			<?php echo intval($frameId);?>,
			<?php echo intval($blockId);?>)">
		<span class="glyphicon glyphicon-share-alt"></span>
		<span><?php echo __('公開申請'); ?></span>
	</button>

	<button
		class="btn btn-primary access-counters-editor-button-publish"
		ng-click="post('Publish',
			<?php echo intval($frameId);?>,
			<?php echo intval($blockId);?>)"
	>
		<span class="glyphicon glyphicon-share-alt"></span>
		<span><?php echo __('公開'); ?></span>
	</button>
</div>