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

//作为命令行的支撑
$application = new Application();
//配置工厂类
$config = new ConfigFactory();
$config = $config();
$commands = $config->get('commands');

//"Rebuild\Command\StartCommand"

foreach ($commands as $command) {
    //对应if是因为还没添加依赖注入
    if($command === StartCommand::class){
        $application->add(new StartCommand($config));
    }else{
        $application->add(new $command);
    }
}
$application->run();

