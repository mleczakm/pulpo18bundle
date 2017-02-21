<?php

/**
 * Created by PhpStorm.
 * User: mleczakm
 * Date: 21.02.17
 * Time: 21:47
 */

namespace mleczakm\Pulpo18Bundle\Command;

use GuzzleHttp\Client;
use mleczakm\PlatformBased\Downloader;
use mleczakm\PlatformBased\Executor;
use mleczakm\PlatformBased\Installer;
use mleczakm\PlatformBased\UnZipper;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Pulpo18Command extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('pulpo')
            ->setDescription('Generates schema of your entities')
            ->addOption(
                'import-project',
                'import-project',
                InputOption::VALUE_REQUIRED,
                'Project directory'
            )
            ->addOption(
                'orm',
                'orm',
                InputOption::VALUE_REQUIRED,
                'ORM version (Doctrine, Doctrine2 or Propel), default Doctrine2',
                'Doctrine2'
            )
            ->addOption(
                'export-image',
                'export-image',
                InputOption::VALUE_REQUIRED,
                'Where should the image should be generated',
                __DIR__
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if(!file_exists(__DIR__ . DIRECTORY_SEPARATOR . '..' .DIRECTORY_SEPARATOR . 'pulpo' . DIRECTORY_SEPARATOR . 'Pulpo')){
            $installer = new Installer(new Downloader(new Client()), new UnZipper());
            $installer->installPackage(array(
                'LINUX' => array('64' => 'http://downloads.pulpo18.com/1.1.0.47/Pulpo-1.1.0.47-Linux-all-64bit.zip')
            ), __DIR__ . DIRECTORY_SEPARATOR . '..' .DIRECTORY_SEPARATOR . 'pulpo');

            exec('chmod +x ' . __DIR__ . DIRECTORY_SEPARATOR . '..' .DIRECTORY_SEPARATOR . 'pulpo' . DIRECTORY_SEPARATOR . 'Pulpo');
        }

        $executor = new Executor();

        $executor->execute(
            __DIR__ . DIRECTORY_SEPARATOR . '..' .DIRECTORY_SEPARATOR . 'pulpo' . DIRECTORY_SEPARATOR . 'Pulpo',
            sprintf(
                '-import-project %s -orm %s -export-image %s',
                $input->getOption('import-project'),
                $input->getOption('orm'),
                $input->getOption('export-image')
            )
        );

        $output->writeln('OK');
    }
}
