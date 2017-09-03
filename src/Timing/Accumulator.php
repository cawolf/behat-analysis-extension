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
     * @var float
     */
    private $startTimestamp = null;

    /**
     * @var float
     */
    private $previousTime = 0;

    /**
     * Saves timestamp for a given point in the execution.
     *
     * @param string $point
     * @param string $type
     * @param string $name
     */
    public function accumulate($point, $type, $name)
    {
        $microtime = microtime(true);

        if (!$this->startTimestamp) {
            $this->startTimestamp = $microtime;
        }

        if ($this->data) {
            $this->previousTime = $this->data[count($this->data) - 1][3];
        }

        $this->data[] = [
            $point,
            $type,
            $name,
            $microtime - $this->startTimestamp,
            $microtime - $this->startTimestamp - $this->previousTime
        ];
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
