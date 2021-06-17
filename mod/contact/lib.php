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
 * Book module core interaction API
 *
 * @package   mod_contact
 * @copyright 2021 Viet Truong
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();
/**
 * Add contact instance.
 *
 * @param stdClass $contact
 */
function contact_add_instance($contact): int {

    global $DB;
    $contact->timecreated = time();
    $contact->timemodified = $contact->timecreated;
    $id = $DB->insert_record('contact', $contact);
    return $id;
}

/**
 * Delete contact instance by activity id
 *
 * @param int $id
 */
function contact_delete_instance(int $id): bool {
    global $DB;

    if (!$contact = $DB->get_record('contact', array('id' => $id))) {
        return false;
    }

    $cm = get_coursemodule_from_instance('contact', $id);
    \core_completion\api::update_completion_date_event($cm->id, 'contact', $id, null);

    $DB->delete_records('contact_infos', array('contactid' => $contact->id));
    $DB->delete_records('contact', array('id ' => $contact->id));

    return true;
}

/**
 * Update contact instance.
 *
 * @param stdClass $data
 */
function contact_update_instance($data): bool {
    global $DB;

    $data->timemodified = time();
    $data->id = $data->instance;
    $DB->update_record('contact', $data);
    $completiontimeexpected = !empty($data->completionexpected) ? $data->completionexpected : null;
    \core_completion\api::update_completion_date_event($data->coursemodule, 'contact', $data->id, $completiontimeexpected);
    return true;
}

/**
 * Supported features
 *
 * @param string $feature FEATURE_xx constant for requested feature
 * @return bool|null
 */
function contact_supports($feature) {
    switch ($feature) {
        case FEATURE_BACKUP_MOODLE2:
            return true;
        default:
            return null;
    }
}
