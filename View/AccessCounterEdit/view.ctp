<?php
/**
 * AccessCounter edit view template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->element('AccessCounterEdit/tab_header'); ?>

<div class="modal-body">
	<div class="tab-content">
		<div id="nc-online-statuses-display-style-<?php echo $frameId; ?>"
			 class="tab-pane active">

			<form name="accessCounterEdit" novalidate>
				<?php echo $this->element('AccessCounterEdit/edit_form'); ?>
			</form>

			<?php echo $this->element('AccessCounterEdit/button'); ?>
		</div>
	</div>
</div>