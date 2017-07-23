@slowAfterFeature
Feature: slow after hook
  Scenario: normal
    Given I execute a fast step
    When I execute a slow step
    Then I execute a step

  @slowBefore
  Scenario: slow before hook
    Given I execute a fast step
    When I execute a fast step
    Then I execute a fast step

  @slowAfter
  Scenario: slow after hook
    Given I execute a fast step
    When I execute a fast step
    Then I execute a fast step
