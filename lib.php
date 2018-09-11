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

function local_coursecleanup_cron() {
    global $CFG, $DB;
        
    return true;
    
}

/**
 * Update the navigation block with coursecleanup options
 * @global moodle_database $DB
 * @global stdClass $USER
 * @global stdClass $CFG
 * @global moodle_page $PAGE
 * @param global_navigation $navigation The navigation block
 */
function local_coursecleanup_extend_navigation(global_navigation $navigation) {
    global $DB, $USER;
    
    //Only display if panorama is installed
    $pr_config = $DB->count_records('config_plugins', array('plugin' => 'local_coursecleanup'));
    if ($pr_config > 0) {
        $node = $navigation->find('local_coursecleanup', navigation_node::TYPE_CONTAINER);
        if (!$node) {
            $node = $navigation->add(get_string('pluginname', 'local_coursecleanup'), null, navigation_node::TYPE_CONTAINER, get_string('pluginname', 'local_coursecleanup'), 'local_coursecleanup');
        }

        $context = context_system::instance();
        //The user can see that IF he has rights on at least one category
        //profile 4 is the READ ONLY. we don't use the local_coursecleanup::PROFILE_READONLY because it is not loaded here
        
        $node->add(get_string('pluginname', 'local_coursecleanup'), new moodle_url('/local/coursecleanup/index.php'));
    }
}

function local_coursecleanup_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options=array()) {
    global $DB;
    
    if ($context->contextlevel != CONTEXT_COURSE) {
        return false;
    }
    
    require_login();
   
    if ($filearea != array('coursecleanup')) {
        return false;
    }
     
    $itemid = (int)array_shift($args);
    
    
    $fs = get_file_storage();
    $filename = array_pop($args);
    
    if (empty($args)) {
        $filepath = '/';
    } else {
        $filepath = '/'.implode('/', $args).'/';
    }
    
    $file = $fs->get_file($context->id, 'local_coursecleanup', $filearea, $itemid, $filepath, $filename);
    if (!$file) {
        return false;
    }
    
    send_stored_file($file, 0, 0, $forcedownload, $options);
}