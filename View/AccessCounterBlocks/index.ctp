<?php
/**
 * AccessCounterBlocks index template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<article class="block-setting-body">
	<?php echo $this->element('NetCommons.setting_tabs', $settingTabs); ?>

	<div class="tab-content">
		<div class="text-right">
			<?php echo $this->Button->addLink(); ?>
		</div>

		<?php echo $this->Form->create('', array(
				'url' => NetCommonsUrl::actionUrl(array('plugin' => 'frames', 'controller' => 'frames', 'action' => 'edit'))
			)); ?>

			<?php echo $this->Form->hidden('Frame.id'); ?>

			<table class="table table-hover">
				<thead>
					<tr>
						<th></th>
						<th>
							<?php echo $this->Paginator->sort('Block.name', __d('access_counters', 'Access counter name')); ?>
						</th>
						<th>
							<?php echo $this->Paginator->sort('AccessCounter.count', __d('access_counters', 'Count number')); ?>
						</th>
						<th>
							<?php echo $this->Paginator->sort('AccessCounter.modified', __d('net_commons', 'Created datetime')); ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($accessCounters as $accessCounter) : ?>
						<tr<?php echo ($this->data['Frame']['block_id'] === $accessCounter['Block']['id'] ? ' class="active"' : ''); ?>>
							<td>
								<?php echo $this->BlockForm->displayFrame('Frame.block_id', $accessCounter['Block']['id']); ?>
							</td>
							<td>
								<?php echo $this->NetCommonsHtml->editLink($accessCounter['Block']['name'], array('block_id' => $accessCounter['Block']['id'])); ?>
							</td>
							<td>
								<?php echo (int)$accessCounter['AccessCounter']['count']; ?>
							</td>
							<td>
								<?php echo $this->Date->dateFormat($accessCounter['AccessCounter']['created']); ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php echo $this->Form->end(); ?>

		<?php echo $this->element('NetCommons.paginator'); ?>
	</div>
</article>




