<?php
/**
 * Created by PhpStorm.
 * User: mleczakm
 * Date: 26.02.17
 * Time: 19:55
 */

namespace mleczakm\Pulpo18Bundle\Command;

use GuzzleHttp\Client;
use mleczakm\PlatformBased\Downloader;
use mleczakm\PlatformBased\Installer;
use mleczakm\PlatformBased\UnZipper;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DownloadCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('pulpo:download')
            ->setDescription('Download Pulpo to your PC')
            ->addArgument('path', InputArgument::REQUIRED, 'Path where Pulpo should be installed.
            You should either pass this value to pulpo:generate ass first argument or add Pulpo directory to OO path.');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Downloading Pulpo package.');

        $path = $input->getArgument('path');

        $installer = new Installer(new Downloader(new Client()), new UnZipper());
        $installer->installPackage(array(
            'linux' => array('64' => 'http://downloads.pulpo18.com/1.1.0.47/Pulpo-1.1.0.47-Linux-all-64bit.zip')
        ), $path);

        $output->writeln('Package downloaded, changing file to executable.');

        exec('chmod +x ' . $path . DIRECTORY_SEPARATOR . 'Pulpo');

    }
}