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
 * local_alias data generator.
 *
 * @package    local_alias
 * @category   test
 * @copyright  2021 NashTech
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * local_alias data generator class.
 *
 * @package    local_alias
 * @category   test
 * @copyright  2009 Petr Skoda  {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class local_alias_generator extends testing_module_generator {

    public function create_instance($record = null, array $options = null) {
        global $CFG;

        // Add default values for alias.
        $record = (array) $record + [
                'friendly' => 'http:/localhost/home',
                'destination' => 'http://localhost/moodle/moodle/local/alias/alias.php',
            ];

        return parent::create_instance($record, (array) $options);
    }
}
