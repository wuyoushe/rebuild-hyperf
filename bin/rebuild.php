<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2020/9/28
 * Time: 15:04
 */

use Symfony\Component\Console\Application;
use Rebuild\Command\StartCommand;

require 'vendor/autoload.php';

//! defined('BASE_PATH') && define('BASE_PATH', dirname(__DIR__, 1));

$application = new Application();
$application->add(new StartCommand());
$application->run();

