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
defined('MOODLE_INTERNAL') || die;

if ($hassiteconfig) {
    $systemcontext = CONTEXT_SYSTEM::instance();

    $ADMIN->add('courses', new admin_category('local_coursecleanup_settings', get_string('course_cleanup', 'local_coursecleanup')));
    
        $ADMIN->add('local_coursecleanup_settings', new admin_externalpage('local_coursecleanup_setting', get_string('pluginname', 'local_coursecleanup'), "$CFG->wwwroot/local/coursecleanup/index.php", 'moodle/course:delete'));

}
