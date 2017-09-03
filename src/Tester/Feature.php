<?php

namespace Cawolf\Behat\Analysis\Tester;

use Behat\Testwork\Environment\Environment;
use Behat\Testwork\Tester\Result\TestResult;
use Behat\Testwork\Tester\SpecificationTester;
use Cawolf\Behat\Analysis\Timing\Accumulator;

/**
 * Feature tester, hooked to @see TesterExtension::SPECIFICATION_TESTER_WRAPPER_TAG
 */
class Feature implements SpecificationTester
{
    const SERVICE_SUFFIX = '.analysis.tester.feature';

    /**
     * @var SpecificationTester
     */
    private $baseTester;

    /**
     * @var Accumulator
     */
    private $accumulator;

    /**
     * @param SpecificationTester $baseTester
     * @param Accumulator $accumulator
     */
    public function __construct(SpecificationTester $baseTester, Accumulator $accumulator)
    {
        $this->baseTester = $baseTester;
        $this->accumulator = $accumulator;
    }

    /** @inheritdoc */
    public function setUp(Environment $env, $spec, $skip)
    {
        $this->accumulator->accumulate(
            Accumulator::POINT_SETUP,
            Accumulator::TYPE_FEATURE,
            $spec->getTitle()
        );
        return $this->baseTester->setUp($env, $spec, $skip);
    }

    /** @inheritdoc */
    public function test(Environment $env, $spec, $skip)
    {
        $this->accumulator->accumulate(
            Accumulator::POINT_TEST,
            Accumulator::TYPE_FEATURE,
            $spec->getTitle()
        );
        return $this->baseTester->test($env, $spec, $skip);
    }

    /** @inheritdoc */
    public function tearDown(Environment $env, $spec, $skip, TestResult $result)
    {
        $this->accumulator->accumulate(
            Accumulator::POINT_TEARDOWN,
            Accumulator::TYPE_FEATURE,
            $spec->getTitle()
        );
        return $this->baseTester->tearDown($env, $spec, $skip, $result);
    }
}
