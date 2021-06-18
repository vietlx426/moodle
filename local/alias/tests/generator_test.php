<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Unit tests for (some of) local/alias/alias.php.
 *
 * @package    local_alias
 * @copyright  2021 Viet Truong
 * @license    http://www.gnu.org/copyleft/gpl.html GNU Public License
 */

defined('MOODLE_INTERNAL') || die();
global $CFG;
require_once(__DIR__ . '/../lib.php');

/**
 * Choice module library functions tests
 *
 * @package    local_alias
 * @copyright  2021 Viet Truong
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @since      Moodle 3.0
 */
class local_alias_generator_testcase extends advanced_testcase {
    public function test_alias_create_instance() {
        global $DB;
        $this->resetAfterTest();
        $this->setAdminUser();
        $data = [
            'friendly' => 'http://test.com/home',
            'destination' => 'http://test.com/local/alias/alias.php'
        ];
        $alias = alias_add_instance($data);
        $records = $DB->get_records('alias', ['id' => $alias]);
        $this->assertEquals(1, count($records));
        $this->assertTrue(array_key_exists($alias, $records));
    }

    public function test_alias_update_instance() {
        global $DB;
        $this->resetAfterTest();
        $this->setAdminUser();

        $data = [
            'friendly' => 'http://test.com/home',
            'destination' => 'http://test.com/local/alias/alias.php'
        ];

        $alias = alias_add_instance($data);

        $dataupdate = [
            'id' => $alias,
            'friendly' => 'http://test.com/update/',
            'destination' => 'http://test.com/local/alias/alias.php'
        ];

        alias_update_instance($dataupdate);

        $check = $DB->get_record('alias', ['id' => $alias]);

        $this->assertEquals($dataupdate['friendly'], $check->friendly);
    }

    public function test_alias_delete_instance() {
        global $SITE, $DB;
        $this->resetAfterTest(true);
        $this->setAdminUser();
        $data = [
            'friendly' => 'http://test.com/home',
            'destination' => 'http://test.com/local/alias/alias.php'
        ];

        $alias = $DB->insert_record('alias', $data);
        alias_delete_instance($alias);
        $count = $DB->count_records('alias', ['id' => $alias]);
        $this->assertEquals(0, $count);
    }
}
