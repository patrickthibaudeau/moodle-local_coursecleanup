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

namespace local_coursecleanup;

class Base {

    /**
     * Creates the Moodle page header
     * @global \stdClass $CFG
     * @global \moodle_database $DB
     * @global \moodle_page $PAGE
     * @global \stdClass $SITE
     * @param string $url Current page url
     * @param string $pagetitle  Page title
     * @param string $pageheading Page heading (Note hard coded to site fullname)
     * @param array $context The page context (SYSTEM, COURSE, MODULE etc)
     * @return HTML Contains page information and loads all Javascript and CSS
     */
    static public function page($url, $pagetitle, $pageheading, $context, $pagelayout = 'standard') {
        global $CFG, $PAGE, $SITE;

        $stringman = get_string_manager();
        $strings = $stringman->load_component_strings('local_coursecleanup', current_language());

        $PAGE->set_url($url);
        $PAGE->set_title($pagetitle);
        $PAGE->set_heading($pageheading);
        $PAGE->set_pagelayout($pagelayout);
        $PAGE->set_context($context);
        $PAGE->requires->strings_for_js(array_keys($strings), 'local_coursecleanup');
    }

    /**
     * This function provides the javascript console.log function to print out php data to the console for debugging.
     * @param string $object
     */
    static public function consoleLog($object) {
        $html = '<script>';
        $html .= 'console.log("' . $object . '")';
        $html .= '</script>';

        echo $html;
    }

    static public function getEditorOptions($context) {
        global $CFG;
        return array('subdirs' => 1, 'maxbytes' => $CFG->maxbytes, 'maxfiles' => -1, 'changeformat' => 1, 'context' => $context, 'noclean' => 1, 'trusttext' => 0);
    }
}
