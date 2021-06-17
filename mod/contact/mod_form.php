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
 * Instance add/edit form
 *
 * @package   mod_contact
 * @copyright 2021 Viet Truong
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot . '/course/moodleform_mod.php');
/**
 * Contact
 */
class mod_contact_mod_form extends moodleform_mod {

    /**
     * Contact form
     */
    public function definition() {
        global $CFG;
        $mform =& $this->_form;

        $mform->addElement('text', 'name', get_string('contactname', 'mod_contact'));
        $mform->setType('name', PARAM_NOTAGS);
        $mform->setDefault('name', 'Test');
        $this->standard_intro_elements(get_string('moduleintro'));
        $this->standard_coursemodule_elements();
        $this->add_action_buttons();

    }

    /**
     * Validate the form data.
     *
     * @param array $contactinfos
     * @param array $files
     * @return array|bool
     */
    public function validation($contactinfos, $files) {
        $contactinfos = (object) $contactinfos;
        $errors = [];
        // Require name.
        if (empty(trim($contactinfos->name))) {
            $errors['name'] = get_string('required');
        }
        return $errors;
    }

}
