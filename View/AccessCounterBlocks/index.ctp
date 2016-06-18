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
	<?php echo $this->BlockTabs->main(BlockTabsHelper::MAIN_TAB_BLOCK_INDEX); ?>

	<?php echo $this->BlockIndex->description(); ?>

	<div class="tab-content">
		<?php echo $this->BlockIndex->create(); ?>
			<?php echo $this->BlockIndex->addLink(); ?>

			<?php echo $this->BlockIndex->startTable(); ?>
				<thead>
					<tr>
						<?php echo $this->BlockIndex->tableHeader(
								'Frame.block_id'
							); ?>
						<?php echo $this->BlockIndex->tableHeader(
								'Block.name', __d('access_counters', 'Access counter name'),
								array('sort' => true, 'editUrl' => true)
							); ?>
						<?php echo $this->BlockIndex->tableHeader(
								'AccessCounter.count', __d('access_counters', 'Count number'),
								array('sort' => true, 'type' => 'numeric')
							); ?>
						<?php echo $this->BlockIndex->tableHeader(
									'Block.public_type', __d('blocks', 'Publishing setting'),
									array('sort' => true)
								); ?>
						<?php echo $this->BlockIndex->tableHeader(
								'TrackableUpdater.handlename', __d('net_commons', 'Modified user'),
								array('sort' => true, 'type' => 'handle')
							); ?>
						<?php echo $this->BlockIndex->tableHeader(
								'Block.modified', __d('net_commons', 'Modified datetime'),
								array('sort' => true, 'type' => 'datetime')
							); ?>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($accessCounters as $accessCounter) : ?>
						<?php echo $this->BlockIndex->startTableRow($accessCounter['Block']['id']); ?>
							<?php echo $this->BlockIndex->tableData(
									'Frame.block_id', $accessCounter['Block']['id']
								); ?>
							<?php echo $this->BlockIndex->tableData(
									'Block.name', $accessCounter['Block']['name'],
									array('editUrl' => array('block_id' => $accessCounter['Block']['id']))
								); ?>
							<?php echo $this->BlockIndex->tableData(
									'AccessCounter.count', $accessCounter['AccessCounter']['count'],
									array('type' => 'numeric')
								); ?>
							<?php echo $this->BlockIndex->tableData(
									'Block.public_type', $accessCounter
								); ?>
							<?php echo $this->BlockIndex->tableData(
									'TrackableUpdater', $accessCounter,
									array('type' => 'handle')
								); ?>
							<?php echo $this->BlockIndex->tableData(
									'Block.modified', $accessCounter['Block']['modified'],
									array('type' => 'datetime')
								); ?>
						<?php echo $this->BlockIndex->endTableRow(); ?>
					<?php endforeach; ?>
				</tbody>
			<?php echo $this->BlockIndex->endTable(); ?>

		<?php echo $this->BlockIndex->end(); ?>

		<?php echo $this->element('NetCommons.paginator'); ?>
	</div>
</article>
