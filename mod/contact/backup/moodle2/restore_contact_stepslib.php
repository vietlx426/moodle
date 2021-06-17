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
 * Defines restore_contact_activity_structure_step class
 *
 * @package     mod_contact
 * @copyright  2021 Viet Truong
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

/**
 * Structure step to restore contact activity
 */
class restore_contact_activity_structure_step extends restore_activity_structure_step {
    /**
     * Define the structure for the contact restore
     */
    protected function define_structure() {

        $paths = array();
        $userinfo = $this->get_setting_value('userinfo');

        $paths[] = new restore_path_element('contact', '/activity/contact');
        if ($userinfo) {
            $paths[] = new restore_path_element('contact_info', '/activity/contact/infos/info');
        }

        return $this->prepare_activity_structure($paths);
    }

    /**
     * Process contact tag information
     *
     * @param array $data information
     */
    protected function process_contact(array $data) {
        global $DB;

        $data = (object) $data;
        $oldid = $data->id;
        $data->course = $this->get_courseid();

        $newitemid = $DB->insert_record('contact', $data);
        $this->apply_activity_instance($newitemid);
    }

    /**
     * Process info tag information
     * @param array $data information
     */
    protected function process_contact_info(array $data) {
        global $DB;

        $data = (object) $data;

        $data->contactid = $this->get_new_parentid('contact');
        $data->userid = $this->get_mappingid('user', $data->userid);

        $newitemid = $DB->insert_record('contact_infos', $data);
    }
    /**
     * After execute
     */
    protected function after_execute() {
        $this->add_related_files('mod_contact', 'intro', null);
    }
}
