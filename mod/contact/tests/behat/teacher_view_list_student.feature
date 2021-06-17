@mod @mod_book @javascript
Feature: View list of student
  In order to see list of student
  As a teacher
  I need to access a contact
  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email                |
      | teacher1 | aaA    | Teacher1 | teacher1@example.com |
      | student1 | bbB      | Student1 | student1@example.com |
    And the following "courses" exist:
      | fullname | shortname | category |
      | Course 1 | C1        | 0        |
    And the following "course enrolments" exist:
      | user     | course | role           |
      | teacher1 | C1     | editingteacher |
      | student1 | C1     | student        |
    And the following "activities" exist:
      | activity   | name   | course |idnumber |
      | contact       | Test contact name |  C1     | contact1    |
    When I log in as "student1"
    And I am on "Course 1" course homepage
    Given I follow "Test contact name"
    And I set the following fields to these values:
      | Name | BEHAT |
      | Email | behat@test.com |
      | Phone | 01235649 |
    And I press "Save changes"
    And I should see "INFORMATION"
    And I log out
  Scenario: View list of students
    When I log in as "teacher1"
    And I am on "Course 1" course homepage
    Given I follow "Test contact name"
    And I should not see "Does not have any data"


