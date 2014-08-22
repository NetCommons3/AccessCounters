<?php
/**
 * setting/index template
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 * @package     app.Plugin.AccessCounters.View.AccessCounters.setting
 */
?>

<div ng-controller="AccessCounters.edit">
<?php
	//編集ボタン
	echo $this->element("AccessCounters.setting/edit_button");

	//メッセージ
	echo $this->element("AccessCounters.setting/result_message");

	//プレビュー
	echo $this->element('AccessCounters.setting/preview_area');

	//本文の表示
	echo $this->element("AccessCounters.index/access_counter_data");

	//状態ラベル
	echo $this->element('AccessCounters.index/status_label', array('showPublish' => true));
?>
	<div class="access-counters-form-area hidden" id="access-counters-form-area-<?php echo intval($frameId);?>">
		<div id="access-counters-form-contents-<?php echo intval($frameId);?>">
			<form style="margin-bottom: 5px;" onsubmit="event.returnValue = false; return false;" method="post" accept-charset="utf-8">
				<?php
					//編集エリア表示
					echo $this->element('AccessCounters.setting/form_content');
				?>
			</form>
		</div>
		<?php
			//ボタン類
			echo $this->element('AccessCounters.setting/form_button');
		?>
	</div>
	<div class="access-counters-form-post-area hidden" id="access-counters-form-post-area-<?php echo intval($frameId);?>">
		<?php
			//POST用編集エリア表示
		?>
	</div>
</div>

