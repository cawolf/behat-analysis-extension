<?php

namespace Cawolf\Behat\Analysis\Context;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /** @var string */
    private $suite;

    /** @var string */
    private $phpBin;

    /** @var Process */
    private $process;

    /**
     * Prepares test folders in the temporary directory.
     *
     * @BeforeScenario
     */
    public function prepareProcess()
    {
        $phpFinder = new PhpExecutableFinder();
        if (false === $php = $phpFinder->find()) {
            throw new \RuntimeException('Unable to find the PHP executable.');
        }
        $this->phpBin = $php;
        $this->process = new Process(null);
    }

    /**
     * @Given I am using the suite :suite
     *
     * @param string $suite
     */
    public function iAmUsingTheSuite($suite)
    {
        Assert::assertInternalType('string', $suite);
        Assert::assertNotEmpty($suite);
        $this->suite = $suite;
    }

    /**
     * @When I execute the suite
     * @When I execute the feature :feature
     *
     * @param string $feature
     */
    public function iExecuteTheSuite($feature = '')
    {
        $this->process->setWorkingDirectory(__DIR__ . '/../..');
        $this->process->setCommandLine(
            sprintf(
                '%s %s -c testapp/behat.yml -s default %s --analyse %s',
                $this->phpBin,
                escapeshellarg(BEHAT_BIN_PATH),
                strtr('--format-settings=\'{"timer": false}\'', ['\'' => '"', '"' => '\"']),
                $feature
            )
        );
        $this->process->setTimeout(90);
        $this->process->start();
        $this->process->wait();
    }

    /**
     * @Then I receive a result file which contains the following accumulations:
     *
     * @param TableNode $table
     */
    public function iReceiveAResultFileWhichContainsTheFollowingAccumulations(TableNode $table)
    {
        $lastTimestamp = 0;
        $csvFile = new \SplFileObject('analysis-steps.csv');
        foreach ($table->getHash() as $row) {
            $currentLine = $csvFile->getCurrentLine();
            Assert::assertStringStartsWith($row['prefix'], $currentLine);

            $timestamp = (float) explode(';', $currentLine)[3];
            Assert::assertGreaterThanOrEqual($lastTimestamp + $row['seconds'], $timestamp);
            $lastTimestamp = $timestamp;
        }
    }
}
