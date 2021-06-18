@local @local_alias @javascript

Feature: Manage alias
  In order to manage alias
  As a manager
  I need to be able to manage alias

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email            |
      | manager  | Max       | Manager  | man@example.com  |
      | teacher  | Luca      | Teacher  | luca@example.com |
    And the following "role assigns" exist:
      | user    | role    | contextlevel | reference |
      | manager | manager | System       |           |

    And I log in as "admin"
    And I navigate to "Appearance > Themes > Theme settings" in site administration
    And I set the field "Custom menu items" to "Alias|/local/alias/alias.php"
    And I click on "Save changes" "button"
    And I log out

  Scenario: Create, edit, delete alias
    And I log in as "manager"
    And I click on "Alias" "link" in the "nav" "css_element"
    And I click on "Add a new alias" "button" in the ".singlebutton" "css_element"
    And I set the field "Friendly" to "Home"
    And I set the field "Destination" to "local/alias/alias.php"
    And I click on "Save changes" "button"
    Then I should see "Home"
    And I click on ".icon[title=Edit]" "css_element"
    And I set the field "Friendly" to "Home Test Edit"
    And I click on "Save changes" "button"
    Then I should see "Home Test Edit"
    And I click on ".icon[title=Delete]" "css_element"
    Then I should not see "Home Test Edit"
