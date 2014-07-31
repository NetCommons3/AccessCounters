<?php
/**
 * AccessCounters configuration file
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 * @since       NetCommons 3.0.0.0
 * @package     app.Plugin.AccessCounters.Config
 */

$config['AccessCounters.Status.Publish'] = 1;
$config['AccessCounters.Status.PublishRequest'] = 2;
$config['AccessCounters.Status.Draft'] = 3;
$config['AccessCounters.Status.Reject'] = 4;

$config['AccessCounters.MaxDigitNumber'] = 10;
$config['AccessCounters.DefalutDigitNumber'] = 6;

$config['AccessCounters.NumberImageTag'] = '{X-NUMBER-IMAGE}';

return $config;
