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


// $mod_types = $modinfo->get_used_module_names();
// foreach ($mod_types as $mod_type => $human_mod_type) {
//     echo "-----------------   " . $human_mod_type;
//     $instances = $modinfo->get_instances_of($mod_type);
//     foreach ($instances as $instance) {
//         var_dump($instance->get_formatted_name());
//         var_dump($instance)
//         echo '<br>';
//     }
//     echo '<br>';
// }


echo '##########################';
echo '##########################';
echo '##########################';

echo '<pre>';
var_dump(count($modinfo->cms));
echo '<br/>';
var_dump(count($modinfo->instances));
echo '</pre>';

foreach ($modinfo->cms as $cm) {
    echo $cm->name;
    echo '<br/>';
}

// foreach ($mods as $cm) {
//     echo "-----------------";
//     echo '<br>';
//     echo var_dump($cm);
//     if (coursemodule_visible_for_user($cm, $USER->id)) {
//     }
//     echo '<br>';
//     echo '<br>';
    
// }

// foreach ($sections as $section_id => $section) {
//     $showsection = $section->uservisible ||
//                 ($section->visible && !$section->available &&
//                     !empty($section->availableinfo))
//                 || (!$section->visible && !$course->hiddensections);
//     if (!$showsection) {
//         continue;
//     }

//     echo "-----------------";
//     echo '<br>';
//     echo $section->name;
//     echo '<br>';
//     echo $section->summary;
//     echo '<br>';
//     foreach ($section->modinfo as $cmid => $mod) {
//         echo $cmid;
//         echo var_dump(get_object_vars($mod));
//     }
//     echo '<br>';
// }

// echo '<pre>';
// echo $sections[0]->name;
// // echo var_dump(array_keys($sections[0]));
// // echo var_dump(get_object_vars($sections[0]));
// echo var_dump($sections[0]->modinfo);
// echo '</pre>';

echo "toto";

// trigger event viewed gantt

echo $OUTPUT->footer();
