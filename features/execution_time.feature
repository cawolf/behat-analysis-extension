Feature: Analyse Behat suites execution time
  In order to improve my Behat suite's performance
  As a suite maintainer
  I want to analyse the suite execution time

  Scenario: Get a report of the execution time
    Given I am using the suite "default"
    When I execute the feature "testapp/features/application.feature:2"
    Then I receive a result file which contains the following accumulations:
      | prefix                        | seconds |
      | setup;suite;default;          | 0       |
      | test;suite;default;           | 0       |
      | setup;feature;application;    | 0       |
      | test;feature;application;     | 0       |
      | teardown;feature;application; | 11      |
      | teardown;suite;default;       | 0       |
