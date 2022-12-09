Feature: View Result Details
  In order to view results
  As a user
  I need to navigate to results page

  Scenario: try View Result Details
    Given I am logged in
    And I am on "/result"
    And I see "View Details"
    When I click "View Details"
    Then I see "Result Details"
