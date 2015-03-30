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

<p class="text-right">
	<?php if ($contentEditable) : ?>
		<span class="nc-tooltip" tooltip="<?php echo __d('net_commons', 'Edit'); ?>">
			<a href="<?php echo $this->Html->url('/access_counters/access_counters/edit/' . $frameId) ?>" class="btn btn-primary">
				<span class="glyphicon glyphicon-cog"> </span>
			</a>
		</span>
	<?php endif; ?>
</p>

<?php if(! $blockKey): ?>
	<?php echo __d('faqs', 'Currently Access Counter has not been published.'); ?>
<?php else: ?>
		<div id="nc-access-counters-container-<?php echo (int)$frameId; ?>"
			 ng-controller="AccessCounters"
			 ng-init="init(
					<?php echo (int)$frameId; ?>,
					<?php echo h(json_encode($counter)); ?>)">

			<div class="text-center">
				<div class="h5">
					<?php
						$displayCounter = (string)$counter['accessCounter']['count'];
						if (strlen($counter['accessCounter']['count']) < (int)$counter['accessCounterFrameSetting']['displayDigit']) {
							$format = '%0' . $counter['accessCounterFrameSetting']['displayDigit'] . 'd';
							$displayCounter = sprintf($format, $counter['accessCounter']['count']);
						}
						$displayCounterLength = strlen($displayCounter);
					?>
					<?php for ($i = 0; $i < $displayCounterLength; $i++): ?>
						<span class="label label-<?php echo $counter['accessCounterFrameSetting']['displayTypeLabel']; ?>">
							<?php echo $displayCounter[$i]; ?>
						</span>
					<?php endfor; ?>
				</div>
			</div>

		</div>
<?php endif;