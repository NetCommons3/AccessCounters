<?php
/**
 * index/status_label template elements
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 * @since       NetCommons 3.0.0.0
 * @package     app.Plugin.AccessCounters.View.Elements.index
 */

$statusHidden[1] = 'hidden';
$statusHidden[2] = 'hidden';
$statusHidden[3] = 'hidden';
$statusHidden[4] = 'hidden';
$allStatusHidden = 'hidden';

//下書き、申請中、差し戻しの状態表示

if (isset($item['AccessCountersFormat']['status_id'])) {
	$status = $item['AccessCountersFormat']['status_id'];
	if ($showPublish && $status == Configure::read('AccessCounters.Status.Publish')) {
		$statusHidden[1] = '';
		$allStatusHidden = '';
	}
	if ($status == Configure::read('AccessCounters.Status.PublishRequest')) {
		$statusHidden[2] = '';
		$allStatusHidden = '';
	}
	if ($status == Configure::read('AccessCounters.Status.Draft')) {
		$statusHidden[3] = '';
		$allStatusHidden = '';
	}
	if ($status == Configure::read('AccessCounters.Status.Reject')) {
		$statusHidden[4] = '';
		$allStatusHidden = '';
	}
}

?>
<p id="access-counters-status-labels-<?php echo intval($frameId); ?>"
   class="<?php echo $allStatusHidden; ?>">

<?php if (! $isSetting && $statusHidden[1] == '' || $isSetting) : ?>
	<span class="label label-info access-counters-status-1 <?php echo $statusHidden[1]; ?>">
		<?php echo __('公開中'); ?>
	</span>
<?php endif; ?>

<?php if (! $isSetting && $statusHidden[2] == '' || $isSetting) : ?>
	<span class="label label-danger access-counters-status-2 <?php echo $statusHidden[2]; ?>">
		<?php echo __("公開申請中"); ?>
	</span>
<?php endif; ?>

<?php if (! $isSetting && $statusHidden[3] == '' || $isSetting) : ?>
	<span class="label label-info access-counters-status-3 <?php echo $statusHidden[3]; ?>">
		<?php echo __("下書き中"); ?>
	</span>
<?php endif; ?>

<?php if (! $isSetting && $statusHidden[4] == '' || $isSetting) : ?>
	<span class="label label-danger access-counters-status-4 <?php echo $statusHidden[4]; ?>">
		<?php echo __("差し戻し中"); ?>
	</span>
<?php endif; ?>

<?php if ($isSetting) : ?>
	<span class="label label-danger access-counters-preview hidden">
		<?php echo __("プレビュー表示中"); ?>
	</span>
<?php endif; ?>

</p>