<?php

namespace Cawolf\Behat\Analysis\Tester;

use Behat\Testwork\Environment\Environment;
use Behat\Testwork\Specification\SpecificationIterator;
use Behat\Testwork\Tester\Result\TestResult;
use Behat\Testwork\Tester\SuiteTester;
use Cawolf\Behat\Analysis\Timing\Accumulator;

/**
 * Suite tester, hooked to @see TesterExtension::SUITE_TESTER_WRAPPER_TAG
 */
class Suite implements SuiteTester
{
    const SERVICE_SUFFIX = '.analysis.tester.suite';

    /**
     * @var SuiteTester
     */
    private $baseTester;

    /**
     * @var Accumulator
     */
    private $accumulator;

    /**
     * Initializes tester.
     *
     * @param SuiteTester $baseTester
     * @param Accumulator $accumulator
     */
    public function __construct(SuiteTester $baseTester, Accumulator $accumulator)
    {
        $this->baseTester = $baseTester;
        $this->accumulator = $accumulator;
    }

    /** @inheritdoc */
    public function setUp(Environment $env, SpecificationIterator $iterator, $skip)
    {
        $this->accumulator->accumulate(
            Accumulator::POINT_SETUP,
            Accumulator::TYPE_SUITE,
            $env->getSuite()->getName()
        );
        return $this->baseTester->setUp($env, $iterator, $skip);
    }

    /** @inheritdoc */
    public function test(Environment $env, SpecificationIterator $iterator, $skip)
    {
        $this->accumulator->accumulate(
            Accumulator::POINT_TEST,
            Accumulator::TYPE_SUITE,
            $env->getSuite()->getName()
        );
        return $this->baseTester->test($env, $iterator, $skip);
    }

    /** @inheritdoc */
    public function tearDown(Environment $env, SpecificationIterator $iterator, $skip, TestResult $result)
    {
        $this->accumulator->accumulate(
            Accumulator::POINT_TEARDOWN,
            Accumulator::TYPE_SUITE,
            $env->getSuite()->getName()
        );
        return $this->baseTester->tearDown($env, $iterator, $skip, $result);
    }
}
