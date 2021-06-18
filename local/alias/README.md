This file is part of Moodle - http://moodle.org/

Moodle is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Moodle is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

copyright 2021 NashTech
license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later


Alias module
=============

Alias module is one of the successors to original 'file' type plugin of Resource module.


TODO:
 * implement portfolio support
# I. Alias Menu

Add menu item:
1. Click Home > Site administration > Appearance > Theme settings
2. Scroll down to the Custom menu items field.
3. Enter: Alias|/local/alias/alias.php
4. Scroll to the bottom of the page and click Save changes


# II. Sitemap
Sitemap:
* Manage alias: http://localhost/moodle/alias/alias.php
* Create alias: http://localhost/moodle/alias/edit.php or click Create new alias button
* Edit alias: http://localhost/moodle/alias/edit.php?id=xx (xx is number of alias id) or Click Edit alias
* Delete alias: Click delete button
* Search alias: Enter keyword and Click Go button
* Pagination: 3 records for each page.

# III. PHPUnit
Run PHPUnit9:
1. Add a new "phpu_moodledata" directory, according to config.php
2. Go to moodle root directory
3. Run this to install phpunit
    * php admin/tool/phpunit/cli/init.php
4. Run testcase
    * vendor\bin\phpunit --filter local_alias_generator_testcase

# IV. Behat
Run Behat:
1. Add a new "behat_moodledata" directory, according to config.php
2. Please make sure, Selemium and chromedriver were installed matching for chrome browser version
    * Or follow instruction moodle https://docs.moodle.org/dev/Running_acceptance_test
3. Go to moodle root directory
4. Run this to install phpunit
    * php admin/tool/behat/cli/init.php
5. Run testcase
    * vendor\bin\behat --config C:\xampp\moodle_alias_behat\behatrun\behat\behat.yml --name="Create, edit, delete alias"
