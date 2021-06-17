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
 * @category    backup
 * @copyright  2021 Viet Truong
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

/**
 * Structure step to backup one contact activity
 */
class backup_contact_activity_structure_step extends backup_activity_structure_step {

    /**
     * Define the structure for the contact activity
     * @return void
     */
    protected function define_structure() {
        // To know if we are including userinfo.
        $userinfo = $this->get_setting_value('userinfo');
        $contact = new backup_nested_element('contact', array('id'), array(
                'name', 'intro', 'introformat', 'timemodified'));
        $infos = new backup_nested_element('infos');
        $info = new backup_nested_element('info', array('id'), array(
                'name', 'email', 'phone', 'userid', 'timemcreated', 'timemodified'));

        $contact->add_child($infos);
        $infos->add_child($info);
        $contact->set_source_table('contact', array('id' => backup::VAR_ACTIVITYID));
        $info->set_source_sql(
                "SELECT *
                        FROM {contact_infos}
                        WHERE contactid = ?",
                array(backup::VAR_PARENTID));
        if ($userinfo) {
            $info->set_source_table('contact_infos', array('contactid' => '../../id'));
        }
        $info->annotate_ids('user', 'userid');
        $contact->annotate_files('mod_contact', 'intro', null, $contextid = null); // This file area does not have an itemid.

        return $this->prepare_activity_structure($contact);
    }
}
