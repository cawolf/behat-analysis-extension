<?php

namespace spec\Cawolf\Behat\Analysis\Controller;

use Behat\Testwork\Cli\Controller;
use Cawolf\Behat\Analysis\Controller\Output;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class OutputSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Output::class);
        $this->shouldHaveType(Controller::class);
    }

    function it_configures_commands(Command $command)
    {
        $command->addOption('analyse', null, InputOption::VALUE_NONE, Argument::type('string'))->shouldBeCalled();
        $this->configure($command);
    }

    function it_is_executable(InputInterface $input, OutputInterface $output)
    {
        $this->execute($input, $output)->shouldBeNull();
    }
}
