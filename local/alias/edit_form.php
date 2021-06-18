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
 * The mform for creating and editing a alias
 *
 * @package   local_alias
 * @copyright 2021 Viet Truong
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */

defined('MOODLE_INTERNAL') || die;

require_once("$CFG->libdir/formslib.php");

/**
 * The mform class for creating and editing a alias
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
        $alias = $this->_customdata['alias'];
        $aliasid = isset($alias->id) ? $alias->id : null;

        $mform->addElement('hidden', 'alias_id');
        $mform->setType('alias_id', PARAM_NOTAGS);
        $mform->setDefault('alias_id', $aliasid);

        $mform->addElement('text', 'friendly', get_string('friendly', 'local_alias'));
        $mform->setType('friendly', PARAM_NOTAGS);

        $mform->addElement('text', 'destination', get_string('destination', 'local_alias'));
        $mform->setType('destination', PARAM_NOTAGS);

        $this->add_action_buttons();
        $this->set_data($alias);
    }

    // Custom validation should be added here.

    /**
     * Validate the form data.
     *
     * @param array $alias
     * @param array $files
     * @return array|bool
     */
    public function validation($alias, $files) {
        $alias = (object) $alias;

        $errors = [];
        if (empty(trim($alias->friendly))) {
            $errors['friendly'] = get_string('required');
        }
        if (empty(trim($alias->destination))) {
            $errors['destination'] = get_string('required');
        }

        return $errors;
    }
}
