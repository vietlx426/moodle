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
 * Edit book chapter
 *
 * @package    mod_contact
 * @copyright  2021 Viet Truong
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/edit_form.php');
global $DB, $USER;

$id = required_param('id', PARAM_INT);
$cm = get_coursemodule_from_id('contact', $id, 0, false, MUST_EXIST);
$contact = $DB->get_record('contact', array('id' => $cm->instance));

$context = context_module::instance($cm->id);
require_login();
require_capability('mod/mod_contact:createinfo', $context);

$PAGE->set_url('/mod/contact/edit.php', array('id' => $id));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title($contact->name);
$PAGE->set_heading($contact->name);

$contactinfo = $DB->get_record('contact_infos', array('userid' => $USER->id, 'contactid' => $contact->id));
$contactform = new edit(new moodle_url($PAGE->url), array('contactinfo' => $contactinfo, 'contactid' => $contact->id));

$returnurl = new moodle_url('/mod/contact/view.php', ['id' => $id]);

if ($contactform->is_cancelled()) {
    redirect($returnurl);
} else if ($fromform = $contactform->get_data()) {
    $data = new stdClass();
    $data->name = $fromform->name;
    $data->email = $fromform->email;
    $data->phone = $fromform->phone;
    $data->contactid = $contact->id;
    $data->userid = $USER->id;
    if (isset($fromform->contactinfo)) {
        $data->id = $fromform->contactinfo;
        $DB->update_record('contact_infos', $data);
        $message = get_string('updateinfo', 'mod_contact');
    } else {
        $DB->insert_record('contact_infos', $data);
        $message = get_string('createinfo', 'mod_contact');
    }
    redirect($returnurl, $message);
}
echo $OUTPUT->header();
$contactform->display();

echo $OUTPUT->footer();
