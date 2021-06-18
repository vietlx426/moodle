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
 *
 *
 * @package
 * @copyright  2021 Viet Truong
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/edit_form.php');
require_once(__DIR__ . '/lib.php');

global $DB, $USER, $PAGE;
$id = optional_param('id', 0, PARAM_INT);
$baseurl = new moodle_url('/local/alias/edit.php');
$context = context_system::instance();

$PAGE->set_context($context);
$PAGE->set_url('/local/alias/edit.php');
$PAGE->set_pagelayout('admin');
$PAGE->set_heading(get_string('headingname', 'local_alias'));
$PAGE->set_title(get_string('createalias', 'local_alias'));
$PAGE->navbar->ignore_active();
$PAGE->navbar->add(get_string('managealias', 'local_alias'), $baseurl);

require_login(0, false);
require_capability('local/alias:accessable', $context);

$alias = $DB->get_record('alias', ['id' => $id]);
$contactform = new edit(new moodle_url($PAGE->url), ['alias' => $alias, 'id' => $id]);
$returnurl = new moodle_url('/local/alias/alias.php');

if ($contactform->is_cancelled()) {
    redirect($returnurl);
} else if ($fromform = $contactform->get_data()) {

    $data = new stdClass();
    $data->friendly = $fromform->friendly;
    $data->destination = $fromform->destination;

    if ($fromform->alias_id) {
        $data->id = $fromform->alias_id;
        alias_update_instance($data);
    } else {
        alias_add_instance($data);
    }
    redirect($returnurl);
}
echo $OUTPUT->header();
$contactform->display();
echo $OUTPUT->footer();
