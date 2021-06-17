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
 * The mform for creating and editing a info event
 *
 * @package   mod_contact
 * @copyright 2021 Viet Truong
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */

defined('MOODLE_INTERNAL') || die;

require_once("$CFG->libdir/formslib.php");

/**
 * The mform class for creating and editing a info
 *
 * @copyright 2021 Viet Truong
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class edit extends moodleform {
    /**
     * The form definition
     */
    public function definition() {

        $mform = $this->_form;
        $contactinfo = $this->_customdata['contactinfo'];
        $contactid = $this->_customdata['contactid'];

        if (isset($contactinfo->id)) {
            $mform->addElement('hidden', 'contactinfo');
            $mform->setType('contactinfo', PARAM_NOTAGS);
            $mform->setDefault('contactinfo', $contactinfo->id);
        }

        $mform->addElement('hidden', 'contactid');
        $mform->setType('contactid', PARAM_NOTAGS);
        $mform->setDefault('contactid', $contactid);

        $mform->addElement('text', 'name', get_string('infoname', 'mod_contact'));
        $mform->setType('name', PARAM_NOTAGS);

        $mform->addElement('text', 'email', get_string('infoemail', 'mod_contact'));
        $mform->setType('email', PARAM_NOTAGS);

        $mform->addElement('text', 'phone', get_string('infophone', 'mod_contact'));
        $mform->setType('phone', PARAM_NOTAGS);

        $this->add_action_buttons();
        $this->set_data($contactinfo);
    }

    // Custom validation should be added here.

    /**
     * Validate the form data.
     *
     * @param array $contactnew
     * @param array $files
     * @return array|bool
     */
    public function validation($contactnew, $files) {
        global $DB, $USER;
        $contactnew = (object) $contactnew;
        $errors = [];
        if (empty(trim($contactnew->name))) {
            $errors['name'] = get_string('required');
        }
        if (empty(trim($contactnew->phone))) {
            $errors['phone'] = get_string('required');
        }
        if (empty(trim($contactnew->email))) {
            $errors['email'] = get_string('required');
        }
        if (isset($contactnew->contactinfo)) {
            $contact = $DB->get_record('contact_infos', ['id' => $contactnew->contactinfo]);
        }

        if (!isset($contact) or isset($contactnew->email) && $contact->email !== $contactnew->email) {
            $select = $DB->sql_equal('email', ':email', false) . 'AND id <> :userid AND contactid = :contactid';
            $params = array(
                    'email' => $contactnew->email,
                    'userid' => $USER->id,
                    'contactid' => $contactnew->contactid
            );
            if (!validate_email($contactnew->email)) {
                $errors['email'] = get_string('invalidemail');
            } else if ($DB->record_exists_select('contact_infos', $select, $params)) {
                $errors['email'] = get_string('emailexists');
            }
        }

        return $errors;
    }
}
