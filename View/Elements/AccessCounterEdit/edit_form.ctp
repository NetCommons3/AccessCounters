<?php
/**
 * AccessCounter edit edit_form element template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryo Ozawa <ozawa.ryo@withone.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="form-group">
	<div>
		<label for="display_type">
			<?php echo __d('access_counters', 'Display Type'); ?>
		</label>
	</div>
	<div id="display_type" class="btn-group">

		<button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">

			<span class="label label-{{displayTypeLabel}}"
				  ng-repeat="num in formatCount() track by $index"
				  ng-bind="num">
			</span>
			 <span class="caret"></span>

		</button>
		<ul role="menu" class="dropdown-menu nc-counter-display-type">
			<li ng-repeat="displayTypeLabel in <?php echo h(json_encode(AccessCounter::getDisplayTypeOptions())); ?>"
				ng-click="changeDisplayType(displayTypeLabel, $index)">

				<a href="#">
					<span class="label label-{{displayTypeLabel}}"
						  ng-repeat="num in formatCount() track by $index"
						  ng-bind="num">
					</span>
				</a>

			</li>
		</ul>

	</div>
</div>

<div class="form-group">
	<?php
		echo $this->Form->input('AccessCounterFrameSetting.display_digit', array(
			'label' => __d('access_counters', 'Display Digit'),
			'type' => 'select',
			'class' => 'form-control',
			'options' => AccessCounter::getDisplayDigitOptions(),
			'ng-selected' => 'edit.data.AccessCounterFrameSetting.display_digit',
			'ng-model' => 'edit.data.AccessCounterFrameSetting.display_digit',
		));
	?>
</div>

<div class="form-group"">

	<div class="form-group has-feedback"
		 ng-class="getValidationState(accessCounterEdit.$valid)">

		<?php
			echo $this->Form->input('AccessCounter.count_start', array(
				'label' => __d('access_counters', 'Starting Value'),
				'type' => 'number',
				'class' => 'form-control',
				'ng-model' => 'edit.data.AccessCounter.count_start',
				'required' => true,
				'ng-pattern' => '/^(0|[1-9][0-9]{0,8})$/',
				'ng-disabled' => 'counter.AccessCounter.is_started'
			));
		?>

		<div ng-hide="counter.AccessCounter.is_started">
			<span class="form-control-feedback"
				  ng-class="accessCounterEdit.$valid ?
					'glyphicon glyphicon-ok' : 'glyphicon glyphicon-remove'; ">
			</span>

			<p class="help-block">
				<span class="error"
					ng-show="accessCounterEdit.$error.number ||
						accessCounterEdit.$error.pattern">
					<?php echo __d('access_counters', 'Please enter in the range from 0 to 999999999.'); ?>
				</span>
				<span class="error"
					ng-show="!accessCounterEdit.$error.number &&
						accessCounterEdit.$error.required">
					<?php echo __d('access_counters', 'Required field.'); ?>
				</span>
			</p>
		</div>

	</div>
</div>
