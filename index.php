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
require_once('config.php');

/**
 * Display the content of the page
 * @global stdobject $CFG
 * @global moodle_database $DB
 * @global core_renderer $OUTPUT
 * @global moodle_page $PAGE
 * @global stdobject $SESSION
 * @global stdobject $USER
 */
function display_page() {
    // CHECK And PREPARE DATA
    global $CFG, $OUTPUT, $SESSION, $PAGE, $DB, $COURSE, $USER;

    $id = optional_param('id', 0, PARAM_INT); //List id

    require_login(1, false); //Use course 1 because this has nothing to do with an actual course, just like course 1

    $context = context_system::instance();

    if (!has_capability('moodle/course:delete', $context)) {
        redirect($CFG->wwwroot . '/admin/search.php', 'You do not have permission to use this tool', 5);
    }

    $pagetitle = get_string('pluginname', 'local_coursecleanup');
    $pageheading = get_string('pluginname', 'local_coursecleanup');
    $PAGE->requires->js_call_amd('local_coursecleanup/cleanup', 'init');
    echo \local_coursecleanup\Base::page($CFG->wwwroot . '/local/coursecleanup/index.php?id=' . $id, $pagetitle, $pageheading, $context);


    $HTMLcontent = '';
    //**********************
    //*** DISPLAY HEADER ***
    //**********************
    echo $OUTPUT->header();

    //**********************
    //*** DISPLAY CONTENT **
    //**********************
    ?>
    <div id="coursecleanup_wrapper">
        <div class='container-fluid'>
            <div class='row'>
                <div class="col-md-6" style="margin-bottom:10px;">
                    <div class="alert alert-info">
                        <?php echo get_string('instructions', 'local_coursecleanup'); ?>
                    </div>
                    <div>
                        <form id="categoriesForm">
                            <div class="form-group">
                                <label for="categories"><?php echo get_string('categories'); ?></label>
                                <select class="form-control" id="categories"  name="categories">
                                    <?php
                                    $options = local_coursecleanup_getCategories();
                                    foreach ($options as $key => $value) {
                                        echo '<option value="' . $key . '">' . $value . '</option>' . "\n";
                                    }
                                    ?>
                                </select>                                
                            </div>
                            <button type="button" id="btnDelete" class="btn btn-danger" title="<?php echo get_string('delete'); ?>"><?php echo get_string('delete'); ?></button> 
                            <a href="<?php echo $CFG->wwwroot ?>/admin/search.php" class="btn btn-default"><?php echo get_string('cancel', 'local_coursecleanup'); ?></a>
                        </form>
                    </div>
                </div>
                <div class="col-md-6" style="margin-bottom:10px;">
                    <div class="alert alert-info">
    <?php echo get_string('instructions_change_roles', 'local_coursecleanup'); ?>
                    </div>
                    <div>
                        <form id="resetRoleForm">
                            <div class="form-group">
                                <label for="roleCategories"><?php echo get_string('categories'); ?></label>
                                <select class="form-control" id="roleCategories"  name="categories">
                                    <?php
                                    $options = local_coursecleanup_getCategories();
                                    foreach ($options as $key => $value) {
                                        echo '<option value="' . $key . '">' . $value . '</option>' . "\n";
                                    }
                                    ?>
                                </select>
                                <div class="form-group">
                                    <label for="roleCategories"><?php echo get_string('session', 'local_coursecleanup'); ?></label>
                                    <select class="form-control" id="session"  name="session">
                                        <option value="F">Fall</option>                                        
                                        <option value="W">Winter</option>                                        
                                        <option value="Y">Year</option>                                        
                                        <option value="SU">Summer (SU)</option>                                        
                                        <option value="S1">Summer (S1)</option>                                        
                                        <option value="S2">Summer (S2)</option>                                        
                                    </select> 
                                </div>
                                <div class="form-group">
                                    <label for="fromRole"><?php echo get_string('from_role', 'local_coursecleanup'); ?></label>
                                    <select class="form-control" id="fromRole"  name="fromrole">
                                        <?php $roles = local_coursecleanup_get_roles();
                                            foreach ($roles as $role) {
                                                echo '<option value="' . $role->id . '">' . $role->name . '</option>'; 
                                            }
                                        ?>                                       
                                    </select> 
                                </div>
                                <div class="form-group">
                                    <label for="toRole"><?php echo get_string('to_role', 'local_coursecleanup'); ?></label>
                                    <select class="form-control" id="toRole"  name="torole">
                                        <?php $roles = local_coursecleanup_get_roles();
                                            foreach ($roles as $role) {
                                                echo '<option value="' . $role->id . '">' . $role->name . '</option>'; 
                                            }
                                        ?>                                       
                                    </select> 
                                </div>
                            </div>
                            <button type="button" id="btnReset" class="btn btn-danger" title="<?php echo get_string('reset', 'local_coursecleanup'); ?>"><?php echo get_string('reset', 'local_coursecleanup'); ?></button> 
                            <a href="<?php echo $CFG->wwwroot ?>/admin/search.php" class="btn btn-default"><?php echo get_string('cancel', 'local_coursecleanup'); ?></a>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="resultsContainer"></div>
                </div>
            </div>
        </div>
    </div>

    <?php
    //**********************
    //*** DISPLAY FOOTER ***
    //**********************
    echo $OUTPUT->footer();
}

display_page();
?>
