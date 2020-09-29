<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2020/9/28
 * Time: 15:04
 */

use Rebuild\Config\ConfigFactory;
use Symfony\Component\Console\Application;
use Rebuild\Command\StartCommand;

require 'vendor/autoload.php';

! defined('BASE_PATH') && define('BASE_PATH', dirname(__DIR__, 1));

$application = new Application();
$config = new ConfigFactory();
$config = $config();
$commands = $config->get('commands');
var_dump($commands);
foreach ($commands as $command) {
    if($command === StartCommand::class){
        $application->add(new StartCommand($config));
    }else{
        $application->add(new $command);
    }
}
$application->run();

