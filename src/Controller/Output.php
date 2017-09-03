<?php

namespace Cawolf\Behat\Analysis\Controller;

use Behat\Testwork\Cli\Controller;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Controller providing the option to generate the analysis report.
 */
class Output implements Controller
{
    const SERVICE_SUFFIX = '.analysis.controller.output';

    /** @inheritdoc */
    public function configure(SymfonyCommand $command)
    {
        $command->addOption(
            'analyse',
            null,
            InputOption::VALUE_NONE,
            'generates analysis files'
        );
    }

    /** @inheritdoc */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        return null;
    }
}
