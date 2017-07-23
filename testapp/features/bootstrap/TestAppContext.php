<?php

namespace TestApp;

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\AfterStepScope;
use Behat\Behat\Hook\Scope\BeforeStepScope;
use Behat\Behat\Hook\Scope\StepScope;

/**
 * Defines application features from the specific context.
 */
class TestAppContext implements Context
{
    /**
     * @Given I execute a fast step
     */
    public function iExecuteAFastStep()
    {
        sleep(1);
    }

    /**
     * @When I execute a slow step
     *
     * A "before step" hook is applied.
     */
    public function iExecuteASlowStep()
    {
        sleep(4);
    }

    /**
     * @Then I execute a step
     *
     * An "after step" hook is applied.
     */
    public function iExecuteAStep()
    {
        sleep(2);
    }

    /**
     * @Then I execute an unused step
     */
    public function iExecuteAnUnusedStep()
    {
    }

    /**
     * @BeforeStep
     * @AfterStep
     * @BeforeScenario @slowBefore
     * @AfterScenario @slowAfter
     * @BeforeFeature @slowBeforeFeature
     * @AfterFeature @slowAfterFeature
     * @param mixed $scope
     */
    public static function slowHook($scope)
    {
        if ($scope instanceof StepScope) {
            if ($scope instanceof BeforeStepScope
                    && $scope->getStep()->getText() != 'I execute a slow step') {
                return;
            }
            if ($scope instanceof AfterStepScope
                    && $scope->getStep()->getText() != 'I execute a step') {
                return;
            }
        }
        sleep(2);
    }
}
