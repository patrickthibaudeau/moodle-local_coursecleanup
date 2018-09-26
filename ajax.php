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
require_once(dirname(__FILE__) . '/config.php');

global $CFG, $USER, $DB;
$action = required_param('action', PARAM_TEXT);

switch ($action) {
    case 'deleteCourses':
        $categoryId = required_param('categoryid', PARAM_INT);
        local_coursecleanup_removeCourses($categoryId);
        break;
    case 'resetRoles':
        $categoryId = required_param('categoryid', PARAM_INT);
        $session = required_param('session', PARAM_TEXT);
        $fromRole = required_param('fromrole', PARAM_INT);
        $toRole = required_param('torole', PARAM_INT);
        local_coursecleanup_resetRole($categoryId, $session, $fromRole, $toRole);
        break;
}