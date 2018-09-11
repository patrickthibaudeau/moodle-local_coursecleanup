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
    }

    return {
        init: function () {
            initCourseCleanup();
        }
    };
});