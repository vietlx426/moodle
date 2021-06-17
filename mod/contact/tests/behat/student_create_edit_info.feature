@mod @mod_contact @javascript
Feature: Create a info
  In order to create a info for contact
  As a student
  I need to create a info
  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email                |
      | student1 | bbB      | Student1 | student1@example.com |
    And the following "courses" exist:
      | fullname | shortname | category |
      | Course 1 | C1        | 0        |
    And the following "course enrolments" exist:
      | user     | course | role           |
      | student1 | C1     | student        |
    And the following "activities" exist:
      | activity   | name   | course |idnumber |
      | contact       | Test contact name |  C1     | contact1    |
  Scenario: Add info as student
    When I log in as "student1"
    And I am on "Course 1" course homepage
    Given I follow "Test contact name"
    And I set the following fields to these values:
      | Name | BEHAT |
      | Email | behat@test.com |
      | Phone | 01235649 |
    And I press "Save changes"
    And I should see "You created a contact"
    Then I press "Edit contact"
    And I set the following fields to these values:
      | Name | BEHAT EDIT |
    And I press "Save changes"
    And I should see "You updated a contact"





