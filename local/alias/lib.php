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
 * Alias module core interaction API
 *
 * @package   local_alias
 * @copyright 2021 Viet Truong
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

function alias_add_instance($data) {
    global $DB;
    return $DB->insert_record('alias', $data);
}

function alias_update_instance($data) {
    global $DB;
    $DB->update_record('alias', $data);
    return true;
}

function alias_delete_instance($id) {
    global $DB;
    $DB->delete_records('alias', ['id' => $id]);
    return true;
}
