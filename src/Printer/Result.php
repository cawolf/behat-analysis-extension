<?php

namespace Cawolf\Behat\Analysis\Printer;

use Behat\Testwork\EventDispatcher\Event\SuiteTested;
use Cawolf\Behat\Analysis\Timing\Accumulator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Prints the results accumulated to a file.
 */
class Result implements EventSubscriberInterface
{
    const SERVICE_ID = 'cawolf.behat.analysis.printer.result';

    /**
     * @var Accumulator
     */
    private $accumulator;

    /**
     * @param Accumulator $accumulator
     */
    public function __construct(Accumulator $accumulator)
    {
        $this->accumulator = $accumulator;
    }

    public function suiteFinished()
    {
        $csvFile = new \SplFileObject('analysis-steps.csv', 'w'); // TODO: configure
        foreach ($this->accumulator->getAccumulatedData() as $row) {
            $csvFile->fputcsv($row, ';');
        }
        $csvFile->fflush();
    }

    /** @inheritdoc */
    public static function getSubscribedEvents()
    {
        return [
            SuiteTested::AFTER => 'suiteFinished'
        ];
    }
}
