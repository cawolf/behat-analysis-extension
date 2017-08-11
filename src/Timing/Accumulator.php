<?php

namespace Cawolf\Behat\Analysis\Timing;

/**
 * Accumulates runtime snippets.
 */
class Accumulator
{
    const SERVICE_ID = 'cawolf.behat.analysis.timing.accumulator';

    const POINT_SETUP = 'setup';
    const POINT_TEST = 'test';
    const POINT_TEARDOWN = 'teardown';

    const TYPE_SUITE = 'suite';
    const TYPE_FEATURE = 'feature';
    const TYPE_SCENARIO = 'scenario';
    const TYPE_STEP = 'step';

    /**
     * @var array
     */
    private $data = [];

    /**
     * Saves timestamp for a given point in the execution.
     *
     * @param string $point
     * @param string $type
     * @param string $name
     */
    public function accumulate($point, $type, $name)
    {
        $this->data[] = [$point, $type, $name, microtime(true)];
    }

    /**
     * Returns all accumulated data.
     *
     * @return array
     */
    public function getAccumulatedData()
    {
        return $this->data;
    }
}
