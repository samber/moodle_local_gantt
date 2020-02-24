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
 * @package     local_gantt
 * @copyright   2019 Samuel Berthe <contact@samuel-berthe.fr>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');

$courseid   = optional_param('courseid', 0, PARAM_INT);

if (!$courseid) {
    print_error('missingparameter');
}

if ($course = $DB->get_record('course', array('id' => $courseid))) {
    $PAGE->set_url('/local/gantt/view.php', array('id' => $course->id));
} else {
    throw new \moodle_exception('Unable to find course with cmid ' . $cmid);
}

require_login($course);
$title = get_string('view_page_title', 'local_gantt');
$PAGE->set_title($title);
$PAGE->set_context(context_course::instance($course->id));
$PAGE->set_heading($title . ' - ' . $course->fullname);
$PAGE->set_pagelayout('incourse');

echo $OUTPUT->header();
echo $OUTPUT->heading($title . ' - ' . format_string($course->fullname));

// get course
$modinfo = get_fast_modinfo($course);
// get course-module instance aka activities
$cms = $modinfo->get_cms();
$sections = $modinfo->get_section_info_all();

foreach ($sections as $section) {
    echo "-----------------<br><b></b>";
    echo $section->id;
    echo ' ';
    echo $section->name;
    echo '</b><br/>';
    foreach ($cms as $cm) {
        if ($cm->section == $section->id) {
            echo $cm->get_formatted_name();
            echo '<br>- - - - - - - - ';
            var_dump($cm->availability);
            if ($cm->availability != NULL) {
                $info = new \core_availability\info_module($cm);
                echo '<br>- - - - - - - - ';
                var_dump($info->get_availability_tree());
                // echo '<br>- - - - - - - - ';
                // var_dump($info->get_availability_tree()->get_full_information($info));
            }
            echo '<br/>';
        }
    }
    echo '<br/>';
    echo '<br/>';

}

echo $OUTPUT->footer();
