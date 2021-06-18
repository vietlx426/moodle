<?php
// This file is part of Moodle Course Rollover Plugin
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
 * @package     local_alias
 * @author      Viet Truong
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/lib.php');
require_once(dirname(__FILE__) . '/filter_form.php');

global $DB, $PAGE;
$deleteid = optional_param('delete_id', 0, PARAM_INT);
$page = optional_param('page', 0, PARAM_INT);
$perpage = 3;
$baseurl = new moodle_url('/local/alias/alias.php');
$context = context_system::instance();

$PAGE->set_context($context);
$PAGE->set_url('/local/alias/alias.php');
$PAGE->set_pagelayout('admin');
$PAGE->set_heading(get_string('headingname', 'local_alias'));
$PAGE->set_title(get_string('pluginname', 'local_alias'));
$PAGE->navbar->ignore_active();
$PAGE->navbar->add(get_string('managealias', 'local_alias'), $baseurl);

require_login(0, false);
require_capability('local/alias:accessable', $context);

echo $OUTPUT->header();

$mform = new filter_form();
$aliasfilter = '';
if ($formdata = $mform->get_data()) {
    $aliasfilter = $formdata->filter;
}
$q = '%' . $aliasfilter . '%';
$count = $DB->count_records('alias');
$start = $page * $perpage;
if ($start > $count) {
    $page = 0;
    $start = 0;
}
$sql = 'SELECT *
        FROM {alias} a
        WHERE a.friendly LIKE ?
        ORDER BY a.id ASC';
$alias = $DB->get_records_sql($sql, array($q), $start, $perpage);

if ($deleteid) {
    alias_delete_instance($deleteid);
    redirect($PAGE->url);
}
$table = new html_table();
$table->head = [];
$table->colclasses = [];
$table->head = [
    get_string('friendly', 'local_alias'),
    get_string('destination', 'local_alias'),
    get_string('edit', 'local_alias'),
    get_string('delete', 'local_alias')
];
$table->attributes['class'] = 'admintable generaltable table-sm';
$table->colclasses[] = 'centeralign';
$table->id = "contacts";
foreach ($alias as $item) {
    $editurl = new moodle_url('/local/alias/edit.php', ['id' => $item->id]);
    $deleteurl = new moodle_url('/local/alias/alias.php', ['delete_id' => $item->id, 'sesskey' => sesskey()]);
    $buttons = [];
    $row = [
        $item->friendly,
        $item->destination,
        $buttons[] = html_writer::link($editurl, $OUTPUT->pix_icon('t/edit', get_string('edit', 'local_alias'))),
        $buttons[] = html_writer::link($deleteurl, $OUTPUT->pix_icon('t/edit', get_string('delete', 'local_alias'))),
    ];
    $table->data[] = $row;
}
$createurl = new moodle_url('/local/alias/edit.php');
$mform->display();
echo html_writer::start_tag('div', ['class' => 'no-overflow']);
echo html_writer::table($table);
echo html_writer::end_tag('div');
echo $OUTPUT->paging_bar($count, $page, $perpage, $baseurl);
echo $OUTPUT->single_button($createurl, get_string('addnewalias', 'local_alias'), 'get');
echo $OUTPUT->footer();
