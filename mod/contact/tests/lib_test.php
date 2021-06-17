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
 * Unit tests for (some of) mod/quiz/locallib.php.
 *
 * @package    mod_contact
 * @category   test
 * @copyright  2008 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU Public License
 */

defined('MOODLE_INTERNAL') || die();
global $CFG;
require_once($CFG->dirroot . '/mod/contact/lib.php');

/**
 * Choice module library functions tests
 *
 * @package    mod_contact
 * @category   test
 * @copyright  2015 Juan Leyva <juan@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @since      Moodle 3.0
 */
class mod_contact_lib_testcase extends advanced_testcase {

    public function test_contact_add_instance() {

        global $DB;
        $this->resetAfterTest();
        $this->setAdminUser();

        $course = $this->getDataGenerator()->create_course();

        $this->assertFalse($DB->record_exists('contact', array('course' => $course->id)));
        $contact = $this->getDataGenerator()->create_module('contact', array('course' => $course));
        $records = $DB->get_records('contact', array('course' => $course->id), 'id');
        $this->assertEquals(1, count($records));
        $this->assertTrue(array_key_exists($contact->id, $records));

        $params = array('course' => $course->id, 'name' => 'Another contact');
        $contact = $this->getDataGenerator()->create_module('contact', $params);
        $records = $DB->get_records('contact', array('course' => $course->id), 'id');
        $this->assertEquals(2, count($records));
        $this->assertEquals('Another contact', $records[$contact->id]->name);

    }

    public function test_contact_delete_instance() {

        global $SITE, $DB;
        $this->resetAfterTest(true);
        $this->setAdminUser();
        $contactgenerator = $this->getDataGenerator()->get_plugin_generator('mod_contact');
        $contact = $contactgenerator->create_instance(array('course' => $SITE->id));
        contact_delete_instance($contact->id);
        $count = $DB->count_records('contact', array('id' => $contact->id));
        $this->assertEquals(0, $count);
    }

}