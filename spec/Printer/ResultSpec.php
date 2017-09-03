<?php

namespace spec\Cawolf\Behat\Analysis\Printer;

use Cawolf\Behat\Analysis\Printer\Result;
use Cawolf\Behat\Analysis\Timing\Accumulator;
use PhpSpec\ObjectBehavior;
use PHPUnit\Framework\Assert;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ResultSpec extends ObjectBehavior
{
    function let(Accumulator $accumulator)
    {
        $this->beConstructedWith($accumulator);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Result::class);
        $this->shouldHaveType(EventSubscriberInterface::class);
    }

    function it_listens_to_suite_finished_and_prints_to_a_csv_file(Accumulator $accumulator)
    {
        $accumulator->getAccumulatedData()->shouldBeCalled()->willReturn([]);
        $this->suiteFinished();
        Assert::assertFileExists('analysis-steps.csv');
        unlink('analysis-steps.csv');
    }
}
