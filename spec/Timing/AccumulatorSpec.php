<?php

namespace spec\Cawolf\Behat\Analysis\Timing;

use Cawolf\Behat\Analysis\Timing\Accumulator;
use PhpSpec\ObjectBehavior;

class AccumulatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Accumulator::class);
    }

    function it_accumulates_execution_times()
    {
        $this->accumulate(Accumulator::POINT_SETUP, Accumulator::TYPE_SUITE, 'a suite');
        $this->accumulate(Accumulator::POINT_TEST, Accumulator::TYPE_SUITE, 'a suite');
        $this->accumulate(Accumulator::POINT_TEARDOWN, Accumulator::TYPE_SUITE, 'a suite');
        $this->getAccumulatedData()->shouldHaveCount(3);

        $exampleData = $this->getAccumulatedData()[0];
        $exampleData->shouldBeArray();
        $exampleData->shouldHaveCount(5);
        $exampleData[0]->shouldEqual(Accumulator::POINT_SETUP);
        $exampleData[1]->shouldEqual(Accumulator::TYPE_SUITE);
        $exampleData[2]->shouldEqual('a suite');
        $exampleData[3]->shouldBeFloat();
        $exampleData[4]->shouldBeFloat();
    }
}
