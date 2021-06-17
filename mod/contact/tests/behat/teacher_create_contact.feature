@mod @mod_contact @javascript
Feature: Create a contact
  In order to see contact of students
  As a teacher
  I need to create a contact
  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email                |
      | teacher1 | aaA    | Teacher1 | teacher1@example.com |
    And the following "courses" exist:
      | fullname | shortname | category |
      | Course 1 | C1        | 0        |
    And the following "course enrolments" exist:
      | user     | course | role           |
      | teacher1 | C1     | editingteacher |
  Scenario: Add contact as teacher
    When I log in as "teacher1"
    And I am on "Course 1" course homepage with editing mode on
    And I add a "Contact" to section "1" and I fill the form with:
      | Name        | Test contact name        |
    Given I follow "Test contact name"
    And I should see "Does not have any data"