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
 * Defines backup_contact_activity_task class
 *
 * @package     mod_contact
 * @category    backup
 * @copyright  2021 Viet Truong
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot . '/mod/contact/backup/moodle2/backup_contact_stepslib.php');

/**
 * Provides the steps to perform one complete backup of the Contact instance
 */
class backup_contact_activity_task extends backup_activity_task {

    /**
     * Define (add) particular settings this activity can have
     *
     * @return void
     */
    protected function define_my_settings() {
        // No particular settings for this activity.
    }

    /**
     * Define (add) particular steps this activity can have
     *
     * @return void
     */
    protected function define_my_steps() {
        $this->add_step(new backup_contact_activity_structure_step('contact_structure', 'contact.xml'));
    }

    /**
     * Code the transformations to perform in the activity in
     * order to get transportable (encoded) links
     *
     * @param string $content
     */
    static public function encode_content_links($content): string {
        global $CFG;
        $base = preg_quote($CFG->wwwroot, "/");

        $search = "/(" . $base . "\/mod\/contact\/index.php\?id\=)([0-9]+)/";
        $content = preg_replace($search, '$@CONTACTINDEX*$2@$', $content);

        $search = "/(" . $base . "\/mod\/contact\/view.php\?id\=)([0-9]+)/";
        $content = preg_replace($search, '$@CONTACTVIEWBYID*$2@$', $content);

        return $content;
    }
}