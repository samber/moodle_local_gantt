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
 
defined('MOODLE_INTERNAL') || die();

function local_gantt_extend_navigation_course(navigation_node $parentnode, stdClass $course, context_course $context) {
    // if (!get_config('local_gantt', 'enabled')) {
    //     return;
    // }

    $url = new moodle_url('/local/gantt/view.php', array('courseid' => $course->id));
    $name = get_string('view_page_title', 'local_gantt');

    $parentnode->add($name, $url, navigation_node::TYPE_SETTING, null, null, new pix_icon('i/report', ''));
}
