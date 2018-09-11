<?php

/**
 * *************************************************************************
 * *                          coursecleanup                               **
 * *************************************************************************
 * @package     local                                                     **
 * @subpackage  coursecleanup                                             **
 * @name        coursecleanup                                             **
 * @copyright   Glendon York University                                   **
 * @link        http://www.glendon.yorku.ca                               **
 * @author                                                                **
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later  **
 * *************************************************************************
 * ************************************************************************ */
defined('MOODLE_INTERNAL') || die();

/**
 * 
 * @global stdClass $CFG
 * @global moodle_database $DB
 * @param type $category
 */
function local_coursecleanup_removeCourses($category = 0) {
    global $CFG, $DB;

    //Get category path
    $categorySql = 'SELECT * from {course_categories} WHERE path LIKE "%/' . $category . '%"';
    $categories = $DB->get_records_sql($categorySql);

    raise_memory_limit(MEMORY_UNLIMITED);

    foreach ($categories as $currentCategory) {

        $courses = $DB->get_records('course', ['category' => $currentCategory->id]);

        if (count($courses) == 0) {
            echo 'No courses in category: ' . $currentCategory->name . '<br><br>';
        } else {
            foreach ($courses as $course) {
                $itemData = [
                    $course->id,
                    'course',
                    'category'
                ];
                $gradeItemsSql = 'SELECT * FROM {grade_items} WHERE courseid = ? AND itemtype != ? AND itemtype != ?';
                $gradeItems = $DB->get_records_sql($gradeItemsSql, $itemData);

                $courseModulesSql = 'SELECT * FROM {course_modules} WHERE course = ? AND deletioninprogress = ?';
                $courseModules = $DB->get_records_sql($courseModulesSql, [$course->id, 0]);

                if ((count($gradeItems) == 0) && (count($courseModules) == 1)) {
                    echo $course->fullname . ' is being deleted<br><br>';
                    if (delete_course($course)) {
                        echo $course->fullname . ' has been deleted<br><br>';
                    }
                } else {
                    echo $course->fullname . ' has not been deleted.<br><br>';
                }
            }
        }
    }
    raise_memory_limit(MEMORY_STANDARD);
}

function local_coursecleanup_getCategories($categoryid = 0) {
    global $CFG, $DB;
    require_once($CFG->dirroot . '/course/lib.php');
    require_once($CFG->libdir . '/coursecatlib.php');

    // Get list of categories to use as parents, with site as the first one.
    $options = array();
    $options[0] = get_string('select');
    // Making a new category
    $options += coursecat::make_categories_list('moodle/category:manage');

    return $options;
}
