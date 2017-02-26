<?php

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Created by PhpStorm.
 * User: mleczakm
 * Date: 21.02.17
 * Time: 22:19
 */
class Pulpo18CommandTest extends KernelTestCase
{
    public function testExecute()
    {
        $application = new Application();

        $application->add(new \mleczakm\Pulpo18Bundle\Command\GenerateCommand());

        $command = $application->find('pulpo:generate');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command' => $command->getName(),
            '--import-project' => __DIR__,
            '--orm' => 'Doctrine2',
            '--export-image' => __DIR__,
        ));

        $output = $commandTester->getDisplay();

        echo $output;
    }
}
