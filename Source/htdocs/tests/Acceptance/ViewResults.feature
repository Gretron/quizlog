Feature: View Results
  In order to view results
  As a user
  I need to navigate to results page

  Scenario: try View Results
    Given I am logged in
    When I click "History"
    Then I see "Results"
