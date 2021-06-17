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
 * Defines backup_chat_activity_task class
 *
 * @package     mod_contact
 * @copyright  2021 Viet Truong
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/contact/backup/moodle2/restore_contact_stepslib.php');


/**
 * contact restore task that provides all the settings and steps to perform one complete restore of the activity
 *
 * @copyright  2010 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class restore_contact_activity_task extends restore_activity_task {

    /**
     * Define (add) particular settings this activity can have
     *
     * @return void
     */
    protected function define_my_settings() {
        // No particular settings for this activity.
    }

    /**
     * Define (add) particular steps this activity can have
     *
     * @return void
     */
    protected function define_my_steps() {
        $this->add_step(new restore_contact_activity_structure_step('contact_structure', 'contact.xml'));
    }

    /**
     * Define the contents in the activity that must be
     * processed by the link decoder
     *
     */
    static public function define_decode_contents(): array {
        $contents = array();

        $contents[] = new restore_decode_content('contact', array('intro'), 'contact');

        return $contents;
    }

    /**
     * Define the decoding rules for links belonging
     * to the activity to be executed by the link decoder
     *
     */
    static public function define_decode_rules(): array {
        $rules = array();

        $rules[] = new restore_decode_rule('CONTACTVIEWBYID', '/mod/contact/view.php?id=$1', 'course_module');

        return $rules;
    }

    /**
     * Define the restore log rules that will be applied
     */
    static public function define_restore_log_rules(): array {
        $rules = array();

        $rules[] = new restore_log_rule('contact', 'add', 'view.php?id={course_module}', '{contact}');
        $rules[] = new restore_log_rule('contact', 'update', 'view.php?id={course_module}', '{contact}');
        $rules[] = new restore_log_rule('contact', 'view', 'view.php?id={course_module}', '{contact}');

        return $rules;
    }

    /**
     * Define the restore log rules that will be applied
     *
     * Note this rules are applied when restoring course logs
     * by the restore final task, but are defined here at
     * activity level. All them are rules not linked to any module instance (cmid = 0)
     *
     */
    static public function define_restore_log_rules_for_course(): array {
        $rules = array();

        $rules[] = new restore_log_rule('contact', 'view all', 'index.php?id={course}', null);

        return $rules;
    }
}
