<?php

namespace spec\Cawolf\Behat\Analysis\Tester;

use Behat\Gherkin\Node\FeatureNode;
use Behat\Testwork\Environment\Environment;
use Behat\Testwork\Tester\Result\TestResult;
use Behat\Testwork\Tester\SpecificationTester;
use Cawolf\Behat\Analysis\Tester\Feature;
use Cawolf\Behat\Analysis\Timing\Accumulator;
use PhpSpec\ObjectBehavior;

class FeatureSpec extends ObjectBehavior
{
    function let(SpecificationTester $baseTester, Accumulator $accumulator)
    {
        $this->beConstructedWith($baseTester, $accumulator);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Feature::class);
        $this->shouldHaveType(SpecificationTester::class);
    }

    function it_sets_up_accumulator(FeatureNode $feature, Environment $env, Accumulator $accumulator)
    {
        $feature->getTitle()->willReturn('a feature title');
        $accumulator->accumulate(Accumulator::POINT_SETUP, Accumulator::TYPE_FEATURE, 'a feature title')->shouldBeCalled();
        $this->setUp($env, $feature, false);
    }

    function it_tests_accumulator(FeatureNode $feature, Environment $env, Accumulator $accumulator)
    {
        $feature->getTitle()->willReturn('a feature title');
        $accumulator->accumulate(Accumulator::POINT_TEST, Accumulator::TYPE_FEATURE, 'a feature title')->shouldBeCalled();
        $this->test($env, $feature, false);
    }

    function it_tears_down_accumulator(FeatureNode $feature, Environment $env, Accumulator $accumulator, TestResult $result)
    {
        $feature->getTitle()->willReturn('a feature title');
        $accumulator->accumulate(Accumulator::POINT_TEARDOWN, Accumulator::TYPE_FEATURE, 'a feature title')->shouldBeCalled();
        $this->tearDown($env, $feature, false, $result);
    }
}
