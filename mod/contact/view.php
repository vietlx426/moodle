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
 * This page is the entry page into the contact UI.
 *
 * @package   mod_contact
 * @copyright 2021 Viet Truong
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/edit_form.php');

$id = optional_param('id', 0, PARAM_INT); // Course Module ID, or ...
$cm = get_coursemodule_from_id('contact', $id, 0, false, MUST_EXIST);

global $DB, $USER;
if ($id) {
    if (!$cm = get_coursemodule_from_id('contact', $id)) {
        print_error('invalidcoursemodule');
    }
    if (!$course = $DB->get_record('course', array('id' => $cm->course))) {
        print_error('coursemisconf');
    }
}

$context = context_module::instance($cm->id);
require_login($course, false, $cm);
require_capability('mod/mod_contact:view', $context);

$PAGE->set_url('/mod/contact/view.php', array('id' => $cm->id));
$PAGE->set_title('Student contact');

if (has_capability('mod/mod_contact:createinfo', $context)) {
    $contact = $DB->get_record('contact_infos', array('userid' => $USER->id, 'contactid' => $cm->instance));
    $editurl = new moodle_url('/mod/contact/edit.php', ['id' => $cm->id]);
    if ($contact) {
        $data = (object) [
                'profile' => $OUTPUT->image_url('profile', 'theme'),
                'contact' => $contact,
                'editurl' => $editurl
        ];
        echo $OUTPUT->header();
        echo $OUTPUT->render_from_template('mod_contact/list', $data);
    } else {
        redirect($editurl);
    }

} else {
    echo $OUTPUT->header();
    $contacts = $DB->get_records('contact_infos', ['contactid' => $cm->instance]);
    $table = new html_table();
    $table->head = array();
    $table->colclasses = array();
    $table->head = [
            get_string('template:name', 'mod_contact'),
            get_string('template:email', 'mod_contact'),
            get_string('template:phone', 'mod_contact')
    ];
    $table->attributes['class'] = 'admintable generaltable table-sm';
    $table->colclasses[] = 'centeralign';
    $table->id = "contacts";
    foreach ($contacts as $contact) {
        $row = [
                $contact->name,
                $contact->email,
                $contact->phone
        ];
        $table->data[] = $row;
    }
    if ($contacts) {
        echo html_writer::start_tag('div', array('class' => 'no-overflow'));
        echo html_writer::table($table);
        echo html_writer::end_tag('div');
    } else {
        echo get_string('nodata', 'mod_contact');
    }

}

echo $OUTPUT->footer();
