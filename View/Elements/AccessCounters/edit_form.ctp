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

<?php echo $this->Form->input('Frame.id', array(
			'type' => 'hidden',
			'value' => $frameId
		)
	);?>

<?php echo $this->Form->input('AccessCounter.is_started', array(
			'type' => 'hidden',
			'value' => $counter['accessCounter']['isStarted']
		)
	);?>

<?php echo $this->Form->input('AccessCounterFrameSetting.id', array(
			'type' => 'hidden',
			'value' => (int)$counter['accessCounterFrameSetting']['id']
		)
	);?>

<div class='form-group'>
	<div>
		<label>
			<?php echo __d('access_counters', 'Display Type'); ?>
		</label>
	</div>
	<input type="hidden" name="data[AccessCounterFrameSetting][display_type]" class="form-control" ng-value="counter.accessCounterFrameSetting.displayType">
	<div id="display_type" class="btn-group">
		<button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">
			<h5>
				<?php for ($i = 0; $i < 10; $i++): ?>
					<span class="label label-{{counter.accessCounterFrameSetting.displayTypeLabel}}">
						<?php echo $i ?>
					</span>
				<?php endfor; ?>
				<span class="caret"></span>
			</h5>
		</button>
		<ul role="menu" class="dropdown-menu">
			<li ng-repeat="labelType in <?php echo h(json_encode(AccessCounter::getDisplayTypeOptions())); ?>"
				ng-click="selectLabel($index, labelType)">

				<a href="#">
					<p>
						<?php for ($i = 0; $i < 10; $i++): ?>
							<span class="label label-{{labelType}}">
								<?php echo $i ?>
							</span>
						<?php endfor; ?>
					</p>
				</a>

			</li>
		</ul>
	</div>
	<?php echo $this->element(
		'NetCommons.errors', [
			'errors' => $this->validationErrors,
			'model' => 'AccessCounterFrameSetting',
			'field' => 'display_type',
		]) ?>
</div>

<div class='form-group'>
	<?php echo $this->Form->input('AccessCounterFrameSetting.display_digit',
		array(
			'label' => __d('access_counters', 'Display Digit'),
			'type' => 'select',
			'error' => false,
			'class' => 'form-control',
			'options' => AccessCounter::getDisplayDigitOptions(),
			'selected' => $counter['accessCounterFrameSetting']['displayDigit']
		)); ?>
	<?php echo $this->element(
		'NetCommons.errors', [
			'errors' => $this->validationErrors,
			'model' => 'AccessCounterFrameSetting',
			'field' => 'display_digit',
		]) ?>
</div>

<div class='form-group'>
	<?php
		echo $this->Form->input('AccessCounter.count_start', array(
			'type' => 'number',
			'label' => __d('access_counters', 'Starting Value'),
			'div' => false,
			'error' => false,
			'class' => 'form-control',
			'required' => true,
			'value' => $counter['accessCounter']['countStart'],
			'ng-disabled' => 'counter.accessCounter.isStarted'
		));
	?>
	<?php echo $this->element(
		'NetCommons.errors', [
			'errors' => $this->validationErrors,
			'model' => 'AccessCounter',
			'field' => 'count_start',
		]) ?>
</div>
