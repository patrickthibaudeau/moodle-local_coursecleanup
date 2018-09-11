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
require_once(dirname(__FILE__) . '../../../config.php');
require_once('locallib.php');


require_once($CFG->dirroot . '/local/coursecleanup/classes/Base.php');
require_once($CFG->dirroot . '/local/coursecleanup/classes/iCrud.php');
require_once($CFG->dirroot . '/local/coursecleanup/classes/Notifications.php');