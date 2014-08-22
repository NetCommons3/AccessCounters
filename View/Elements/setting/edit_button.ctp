<?php
/**
 * setting/editor_button template elements
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 * @package     app.Plugin.AccessCounters.View.Elements.setting
 */

//公開するボタンの非表示
$publishBtnHidden = 'hidden';
if ($isPublisher
		&& isset($item['AccessCountersFormat']['status_id'])
		&& $item['AccessCountersFormat']['status_id'] == Configure::read('AccessCounters.Status.PublishRequest')) {

	$publishBtnHidden = '';
}
?>

<p class="text-right"
   id="access-counters-content-edit-btn-area-<?php echo intval($frameId); ?>"
>
	<button class="btn btn-default"
		ng-click="openBlockSetting(<?php echo intval($frameId); ?>)"
	>
		<span class="glyphicon glyphicon-cog"> <?php echo __("ブロック設定"); ?></span>
	</button>

	<button class="btn btn-primary"
		ng-click="openEditForm(<?php echo intval($frameId); ?>,
			<?php echo intval($blockId); ?>)"
	>
		<span class="glyphicon glyphicon-pencil"> <?php echo __("編集"); ?></span>
	</button>

	<?php if ($isPublisher) : ?>
	<button class="btn btn-danger access-counters-btn-publish <?php echo $publishBtnHidden; ?>"
		ng-click="post('Publish',
			<?php echo intval($frameId);?>,
			<?php echo intval($blockId);?>)"
	>
		<span class="glyphicon glyphicon-share-alt"> <?php echo __("公開する"); ?></span>
	</button>
	<?php endif; ?>
</p>
