<?php
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
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
        self::bootKernel();
        $application = new Application(self::$kernel);

        $application->add(new \mleczakm\Pulpo18Bundle\Command\Pulpo18Command());

        $command = $application->find('app:create-user');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command' => $command->getName(),

            // pass arguments to the helper
            '--import-project' => __DIR__,
            '--orm' => 'Doctrine2',
            '--export-image' => __DIR__,
        ));

        $output = $commandTester->getDisplay();

        echo $output;
    }
}
