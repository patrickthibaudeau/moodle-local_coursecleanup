define(['jquery', 'jqueryui'], function ($, jqui) {
    "use strict";

    var wwwroot = M.cfg.wwwroot;

    /**
     * This function is used to add highlighting for the active breadcrump item 
     * Initialising.
     */
    function initCourseCleanup() {
        $('#btnDelete').prop('disabled', 'true');

        $('#categories').change(function () {
            if ($(this).val() != 0) {
                $('#btnDelete').removeAttr('disabled');
            } else {
                $('#btnDelete').prop('disabled', 'true');
            }
        });

        $('#btnDelete').click(function () {
            var categoryId = $('#categories').val();

            if (confirm('Are you sure you want to delete the courses within this category?')) {
                $('#resultsContainer').append('<div style="font-size: 2.0em; text-align: center;"><i class="fa fa-spinner fa-spin"></i></div>');
                $.ajax({
                    url: "ajax.php?action=deleteCourses&categoryid=" + categoryId,
                    data: '',
                    dataType: "html",
                    success: function (results) {
                        $('#resultsContainer').html(results);
                    }
                });
            }
        });
        
        //Reset roles
        $('#btnReset').prop('disabled', 'true');

        $('#roleCategories').change(function () {
            if ($(this).val() != 0) {
                $('#btnReset').removeAttr('disabled');
            } else {
                $('#btnReset').prop('disabled', 'true');
            }
        });

        $('#btnReset').click(function () {
            var categoryId = $('#roleCategories').val();
            var session = $('#session').val();
            var fromRole = $('#fromRole').val();
            var toRole = $('#toRole').val();

            if (confirm('Are you sure you want to reset the role of users for courses within this category?')) {
                $('#resultsContainer').append('<div style="font-size: 2.0em; text-align: center;"><i class="fa fa-spinner fa-spin"></i></div>');
                $.ajax({
                    url: "ajax.php?action=resetRoles&categoryid=" + categoryId,
                    data: '&session=' + session + '&fromrole=' + fromRole + '&torole=' + toRole,
                    dataType: "html",
                    success: function (results) {
                        $('#resultsContainer').html(results);
                    }
                });
            }
        });
    }

    return {
        init: function () {
            initCourseCleanup();
        }
    };
});