Feature: Analyse Behat suites execution time
  In order to improve my Behat suite's performance
  As a suite maintainer
  I want to analyse the suite execution time

  Scenario: Get a report of the execution time
    Given I am using the suite "default"
    When I execute the feature "testapp/features/application.feature:2"
    Then I receive a result file which equals:
      """
      My first extension output!

      """
