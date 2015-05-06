<?php
/**
 * block index template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="modal-body">
	<?php echo $this->element('NetCommons.setting_tabs', $settingTabs); ?>

	<div class="tab-content">
		<div class="text-right">
			<a class="btn btn-success" href="<?php echo $this->Html->url('/access_counters/access_counters/add/' . $frameId);?>">
				<span class="glyphicon glyphicon-plus"> </span>
			</a>
		</div>

		<div id="nc-link-setting-<?php echo $frameId; ?>">
			<?php echo $this->Form->create('', array(
					'url' => '/frames/frames/edit/' . $frameId
				)); ?>

				<?php echo $this->Form->hidden('Frame.id', array(
						'value' => $frameId,
					)); ?>

				<table class="table table-hover">
					<thead>
						<tr>
							<th>#</th>
							<th>
								<?php echo $this->Paginator->sort('AccessCounter.count', __d('access_counters', 'Count')); ?>
							</th>
							<th>
								<?php echo $this->Paginator->sort('Block.public_type', __d('blocks', 'Publishing setting')); ?>
							</th>
							<th>
								<?php echo $this->Paginator->sort('AccessCounter.modified', __d('access_counters', 'Access date')); ?>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($accessCounters as $accessCounter) : ?>
							<tr<?php echo ($blockId === $accessCounter['block']['id'] ? ' class="active"' : ''); ?>>
								<td>
									<?php echo $this->Form->input('Frame.block_id',
										array(
											'type' => 'radio',
											'name' => 'data[Frame][block_id]',
											'options' => array((int)$accessCounter['block']['id'] => ''),
											'div' => false,
											'legend' => false,
											'label' => false,
											'hiddenField' => false,
											'checked' => (int)$accessCounter['block']['id'] === (int)$blockId,
											'onclick' => 'submit()'
										)); ?>
								</td>
								<td>
									<a href="<?php echo $this->Html->url('/access_counters/access_counters/edit/' . $frameId . '/' . (int)$accessCounter['block']['id']); ?>">
										<?php echo (int)$accessCounter['accessCounter']['count']; ?>
									</a>
								</td>
								<td>
									<?php if ($accessCounter['block']['publicType'] === '0') : ?>
										<?php echo __d('blocks', 'Private'); ?>
									<?php elseif ($accessCounter['block']['publicType'] === '1') : ?>
										<?php echo __d('blocks', 'Public'); ?>
									<?php elseif ($accessCounter['block']['publicType'] === '2') : ?>
										<?php echo __d('blocks', 'Limited'); ?>
									<?php endif; ?>
								</td>
								<td>
									<?php echo $this->Date->dateFormat($accessCounter['accessCounter']['modified']); ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php echo $this->Form->end(); ?>

			<div class="text-center">
				<?php echo $this->element('NetCommons.paginator', array(
						'url' => Hash::merge(
							array('controller' => 'blocks', 'action' => 'index', $frameId),
							$this->Paginator->params['named']
						)
					)); ?>
			</div>
		</div>
	</div>
</div>




