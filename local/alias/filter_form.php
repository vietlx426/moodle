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
 * The filter form for filter alias
 *
 * @package   local_alias
 * @copyright 2021 Viet Truong
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir . '/formslib.php');

class filter_form extends moodleform {

    public function definition() {
        $mform =& $this->_form;

        $mform->addElement('text', 'filter', get_string('filter', 'local_alias'));
        $mform->setType('filter', PARAM_TEXT);

        $this->add_action_buttons(false, get_string('search'));
    }

}