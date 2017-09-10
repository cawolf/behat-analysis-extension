<?php

namespace spec\Cawolf\Behat\Analysis\Tester;

use Behat\Behat\Tester\ScenarioTester;
use Behat\Gherkin\Node\FeatureNode;
use Behat\Gherkin\Node\ScenarioInterface;
use Behat\Testwork\Environment\Environment;
use Behat\Testwork\Tester\Result\TestResult;
use Cawolf\Behat\Analysis\Tester\Scenario;
use Cawolf\Behat\Analysis\Timing\Accumulator;
use PhpSpec\ObjectBehavior;

class ScenarioSpec extends ObjectBehavior
{
    function let(ScenarioTester $scenarioTester, Accumulator $accumulator)
    {
        $this->beConstructedWith($scenarioTester, $accumulator);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Scenario::class);
        $this->shouldHaveType(ScenarioTester::class);
    }

    function it_sets_up_accumulator(ScenarioInterface $scenario, FeatureNode $feature, Environment $env, Accumulator $accumulator)
    {
        $scenario->getTitle()->willReturn('a scenario title');
        $accumulator->accumulate(Accumulator::POINT_SETUP, Accumulator::TYPE_SCENARIO, 'a scenario title')->shouldBeCalled();
        $this->setUp($env, $feature, $scenario, false);
    }

    function it_tests_accumulator(ScenarioInterface $scenario, FeatureNode $feature, Environment $env, Accumulator $accumulator)
    {
        $scenario->getTitle()->willReturn('a scenario title');
        $accumulator->accumulate(Accumulator::POINT_TEST, Accumulator::TYPE_SCENARIO, 'a scenario title')->shouldBeCalled();
        $this->test($env, $feature, $scenario, false);
    }

    function it_tears_down_accumulator(ScenarioInterface $scenario, FeatureNode $feature, Environment $env, Accumulator $accumulator, TestResult $result)
    {
        $scenario->getTitle()->willReturn('a scenario title');
        $accumulator->accumulate(Accumulator::POINT_TEARDOWN, Accumulator::TYPE_SCENARIO, 'a scenario title')->shouldBeCalled();
        $this->tearDown($env, $feature, $scenario, false, $result);
    }
}
