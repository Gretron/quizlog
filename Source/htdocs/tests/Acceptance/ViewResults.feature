Feature: View Results
  In order to view results
  As a user
  I need to navigate to results page

  Scenario: try View Results
    Given I am logged in
    And I am on "localhost/home"
    When I click "History"
    Then I am on "/result"
    And I see "%""
