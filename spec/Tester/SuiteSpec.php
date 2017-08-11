<?php

namespace spec\Cawolf\Behat\Analysis\Tester;

use Behat\Testwork\Environment\Environment;
use Behat\Testwork\Specification\SpecificationIterator;
use Behat\Testwork\Tester\Result\TestResult;
use Behat\Testwork\Tester\SuiteTester;
use Cawolf\Behat\Analysis\Tester\Suite;
use Cawolf\Behat\Analysis\Timing\Accumulator;
use PhpSpec\ObjectBehavior;

class SuiteSpec extends ObjectBehavior
{
    function let(SuiteTester $baseTester, Accumulator $accumulator)
    {
        $this->beConstructedWith($baseTester, $accumulator);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Suite::class);
        $this->shouldHaveType(SuiteTester::class);
    }

    function it_sets_up_accumulator(\Behat\Testwork\Suite\Suite $suite, Environment $env, SpecificationIterator $iterator, Accumulator $accumulator)
    {
        $suite->getName()->willReturn('a suite name');
        $env->getSuite()->willReturn($suite);
        $accumulator->accumulate(Accumulator::POINT_SETUP, Accumulator::TYPE_SUITE, 'a suite name')->shouldBeCalled();
        $this->setUp($env, $iterator, false);
    }

    function it_tests_accumulator(\Behat\Testwork\Suite\Suite $suite, Environment $env, SpecificationIterator $iterator, Accumulator $accumulator)
    {
        $suite->getName()->willReturn('a suite name');
        $env->getSuite()->willReturn($suite);
        $accumulator->accumulate(Accumulator::POINT_TEST, Accumulator::TYPE_SUITE, 'a suite name')->shouldBeCalled();
        $this->test($env, $iterator, false);
    }

    function it_tears_down_accumulator(\Behat\Testwork\Suite\Suite $suite, Environment $env, SpecificationIterator $iterator, Accumulator $accumulator, TestResult $result)
    {
        $suite->getName()->willReturn('a suite name');
        $env->getSuite()->willReturn($suite);
        $accumulator->accumulate(Accumulator::POINT_TEARDOWN, Accumulator::TYPE_SUITE, 'a suite name')->shouldBeCalled();
        $this->tearDown($env, $iterator, false, $result);
    }
}
