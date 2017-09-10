<?php

namespace Cawolf\Behat\Analysis\Tester;

use Behat\Behat\Tester\ScenarioTester;
use Behat\Gherkin\Node\FeatureNode;
use Behat\Gherkin\Node\ScenarioInterface;
use Behat\Testwork\Environment\Environment;
use Behat\Testwork\Tester\Result\TestResult;
use Cawolf\Behat\Analysis\Timing\Accumulator;

/**
 * Scenario tester, hooked to @see TesterExtension::SCENARIO_TESTER_WRAPPER_TAG
 */
class Scenario implements ScenarioTester
{
    const SERVICE_SUFFIX = '.analysis.tester.scenario';

    /**
     * @var ScenarioTester
     */
    private $baseTester;

    /**
     * @var Accumulator
     */
    private $accumulator;

    /**
     * @param ScenarioTester $baseTester
     * @param Accumulator $accumulator
     */
    public function __construct(ScenarioTester $baseTester, Accumulator $accumulator)
    {
        $this->baseTester = $baseTester;
        $this->accumulator = $accumulator;
    }

    /** @inheritdoc */
    public function setUp(Environment $env, FeatureNode $feature, ScenarioInterface $scenario, $skip)
    {
        $this->accumulator->accumulate(
            Accumulator::POINT_SETUP,
            Accumulator::TYPE_SCENARIO,
            $scenario->getTitle()
        );
        return $this->baseTester->setUp($env, $feature, $scenario, $skip);
    }

    /** @inheritdoc */
    public function test(Environment $env, FeatureNode $feature, ScenarioInterface $scenario, $skip)
    {
        $this->accumulator->accumulate(
            Accumulator::POINT_TEST,
            Accumulator::TYPE_SCENARIO,
            $scenario->getTitle()
        );
        return $this->baseTester->test($env, $feature, $scenario, $skip);
    }

    /** @inheritdoc */
    public function tearDown(
        Environment $env,
        FeatureNode $feature,
        ScenarioInterface $scenario,
        $skip,
        TestResult $result
    ) {
        $this->accumulator->accumulate(
            Accumulator::POINT_TEARDOWN,
            Accumulator::TYPE_SCENARIO,
            $scenario->getTitle()
        );
        return $this->baseTester->tearDown($env, $feature, $scenario, $skip, $result);
    }
}
