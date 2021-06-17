@mod @mod_assign
Feature: Switch role does not cause an error message in assignsubmission_comments

  Background:
    Given the following "courses" exist:
      | fullname | shortname |
      | Course 1 | C1        |
    And the following "users" exist:
      | username |
      | teacher1 |
    And the following "course enrolments" exist:
      | course | user     | role           |
      | C1     | teacher1 | editingteacher |
    And the following "activities" exist:
      | activity | course | idnumber | name                | intro                        | teamsubmission |
      | assign   | C1     | a1       | Test assignment one | This is the description text | 1              |
    And I log in as "teacher1"
    And I am on "Course 1" course homepage

  Scenario: I switch role to student and an error doesn't occur
    When I follow "Switch role to..." in the user menu
    And I press "Student"
    And I follow "Test assignment"
    Then I should see "This is the description text"
