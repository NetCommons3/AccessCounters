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

<p>
	<?php
		$format = '%0' . (int)$accessCounterFrameSetting['displayDigit'] . 'd';
		$displayCounter = sprintf($format, $accessCounter['count']);
		$displayCounterLength = strlen($displayCounter);
	?>
	<?php for ($i = 0; $i < $displayCounterLength; $i++): ?>
		<span class="label label-<?php echo AccessCounterFrameSetting::$displayTypes[$accessCounterFrameSetting['displayType']]; ?>">
			<?php echo $displayCounter[$i]; ?>
		</span>
	<?php endfor; ?>
</p>
