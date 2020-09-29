<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2020/9/28
 * Time: 17:34
 */

namespace Rebuild\Command;

use Rebuild\Server\ServerFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class StartCommand extends Command
{
    protected $config;

    public function __construct(\Rebuild\Config\Config $config)
    {
        parent::__construct();
        $this->config = $config;
    }

    protected function configure()
    {
        $this->setName('start')->setDescription('启动服务');
    }

    protected function execute(InputInterface $input, OutputInterface $output) :int
    {
        //检查环境
        $config = $this->config;
        $configs = $config->get('server');
        $serverFactory = new ServerFactory();
        $serverFactory->configure($configs);
        $serverFactory->getServer()->start();
        return 1;
    }

}