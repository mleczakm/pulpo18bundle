<?php

/**
 * Created by PhpStorm.
 * User: mleczakm
 * Date: 21.02.17
 * Time: 21:47
 */

namespace mleczakm\Pulpo18Bundle\Command;

use mleczakm\PlatformBased\Executor;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('pulpo:generate')
            ->setDescription('Generates schema of your entities')
            ->addArgument(
                'path',
                InputArgument::OPTIONAL,
                'Path to Pulpo. If not exist, Pulpo binary should be accessible under OS path'
            )
            ->addOption(
                'import-project',
                'import-project',
                InputOption::VALUE_REQUIRED,
                'Project directory',
                'src' . DIRECTORY_SEPARATOR . 'AppBundle'
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
                'Where should the image should be generated, default root app directory',
                'schema.png'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $executor = new Executor();

        $pulpoPath = $input->getArgument('path');
        if ($pulpoPath && is_dir($pulpoPath))
            $pulpoPath = $pulpoPath . DIRECTORY_SEPARATOR . 'Pulpo';

        if ($pulpoPath  && !file_exists($pulpoPath)) {
            $output->writeln('Pulpo not found under given path. Check if is correct. You can also download Pulpo using pulpo:download command.');

            return;
        }

        if (!$pulpoPath && ($pulpoPath = 'Pulpo') && !$executor->commandExist($pulpoPath)) {
            $output->writeln('Pulpo not found, please firstly download Pulpo using pulpo:download command.');

            return;
        }

        $output->writeln(sprintf(
            'Started generating schema for %s project in %s directory.',
            $input->getOption('orm'),
            $input->getOption('import-project')
        ));

        $output->writeln(sprintf('Starting generating schema graph for "%s" directory.', $input->getOption('import-project')));

        $executor->execute(
            $pulpoPath,
            sprintf(
                '-import-project %s -orm %s -export-image %s',
                $input->getOption('import-project'),
                $input->getOption('orm'),
                $input->getOption('export-image')
            )
        );

        $output->writeln(sprintf('Schema successfully generated into %s.', $input->getOption('export-image')));
    }
}
