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
 * *************************************************************************/
defined('MOODLE_INTERNAL') || die();

function xmldb_local_coursecleanup_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager();

    return true;
}
