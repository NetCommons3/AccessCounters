<?php
/**
 * AccessCounterFrameSettings edit form template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->NetCommonsForm->hidden('AccessCounterFrameSetting.id'); ?>

<?php echo $this->NetCommonsForm->hidden('AccessCounterFrameSetting.frame_key'); ?>

<?php echo $this->NetCommonsForm->hidden('Frame.id'); ?>

<?php echo $this->NetCommonsForm->hidden('Frame.key'); ?>

<div class='form-group'>
	<?php echo $this->NetCommonsForm->label('AccessCounterFrameSetting.display_type',
			__d('access_counters', 'Display type')
		); ?>

	<?php echo $this->NetCommonsForm->hidden('AccessCounterFrameSetting.display_type', array(
			'ng-value' => 'counterFrameSetting.displayType'
		)); ?>
	<?php $this->NetCommonsForm->unlockField('AccessCounterFrameSetting.display_type'); ?>

	<div class="btn-group nc-input-dropdown">
		<button type="button" class="dropdown-toggle btn btn-default" data-toggle="dropdown" aria-expanded="false">
			<div class="clearfix">
				<div class="pull-left">
					<?php for ($i = 0; $i < 10; $i++) : ?>
						<span class="label label-{{currentDisplayTypeName}}">
							<?php echo $i ?>
						</span>
					<?php endfor; ?>
				</div>
				<div class="pull-right">
					<span class="caret"> </span>
				</div>
			</div>
		</button>

		<ul class="dropdown-menu text-left" role="menu"
			ng-init="displayTypes = <?php echo h(json_encode(AccessCounterFrameSetting::$displayTypes)); ?>">

			<li ng-repeat="displayType in displayTypes track by $index" ng-class="{active: (($index + 1) == counterFrameSetting.displayType)}">

				<a class="text-left" href="" ng-click="selectDisplayType($index, displayType)">
					<?php for ($i = 0; $i < 10; $i++) : ?>
						<span class="label label-{{displayType}}">
							<?php echo $i ?>
						</span>
					<?php endfor; ?>
				</a>
			</li>
		</ul>
	</div>
</div>

<?php
	for ($i = AccessCounterFrameSetting::DISPLAY_DIGIT_MIN; $i <= AccessCounterFrameSetting::DISPLAY_DIGIT_MAX; $i++) {
		$options[$i] = $i;
	}

	echo $this->NetCommonsForm->input('AccessCounterFrameSetting.display_digit', array(
			'type' => 'select',
			'label' => __d('access_counters', 'Display digit'),
			'options' => $options,
		));
