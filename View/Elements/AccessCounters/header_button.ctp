
<div class="text-right col-xs-11 col-xs-offset-1">

	<?php if (Page::isSetting()) : ?>
		<button class="btn btn-primary"
				ng-click="showManage()"
				tooltip="<?php echo __d('net_commons', 'Manage'); ?>">

			<span class="glyphicon glyphicon-cog"></span>
			<span class="hidden">
				<?php echo __d('net_commons', 'Manage'); ?>
			</span>
		</button>
	<?php endif; ?>
</div>
