/**
 * Universal Table Enhancement Script
 * Automatically applies enhanced styling to all dashboard tables
 */

$(document).ready(function () {
    // Initialize universal table enhancement
    initializeUniversalTableEnhancement();
});

/**
 * Initialize Universal Table Enhancement
 */
function initializeUniversalTableEnhancement() {
    // Wait for DOM to be fully loaded
    setTimeout(function () {
        enhanceAllTables();
        initializeUniversalCheckboxes();
    }, 500);
}

/**
 * Enhance All Tables
 */
function enhanceAllTables() {
    // Find all tables with standard classes and enhance them
    $('table.table, table.table-bordered, table.table-striped').each(function () {
        var $table = $(this);

        // Skip if already enhanced
        if ($table.hasClass('table-enhanced') || $table.closest('.dashboard-table-container').length) {
            return;
        }

        // Wrap table in enhanced container
        var $container = $table.closest('.card, .table-responsive').parent();
        if ($container.length) {
            $container.addClass('dashboard-table-container');
        }

        // Add enhanced class to table
        $table.addClass('table-enhanced');

        // Enhance table headers
        enhanceTableHeaders($table);

        // Enhance table rows
        enhanceTableRows($table);

        // Add action buttons if missing
        addActionButtonsIfMissing($table);

        // Enhance status badges
        enhanceStatusBadges($table);
    });
}

/**
 * Enhance Table Headers
 */
function enhanceTableHeaders($table) {
    var $thead = $table.find('thead tr');

    // Add checkbox column if missing
    if ($thead.find('th input[type="checkbox"]').length === 0) {
        var $firstTh = $thead.find('th:first');
        var $checkboxTh = $('<th class="text-center" style="width: 50px;">' +
            '<div class="checkbox-enhanced">' +
            '<input type="checkbox" id="checkAll" class="form-check-input">' +
            '<span class="checkmark"></span>' +
            '</div>' +
            '</th>');

        $firstTh.before($checkboxTh);
    }

    // Add actions column if missing
    if ($thead.find('th:contains("الإجراءات"), th:contains("Actions")').length === 0) {
        var $actionsTh = $('<th>{{ __("dashboard.actions") }}</th>');
        $thead.append($actionsTh);
    }
}

/**
 * Enhance Table Rows
 */
function enhanceTableRows($table) {
    var $tbody = $table.find('tbody');

    $tbody.find('tr').each(function () {
        var $row = $(this);

        // Add checkbox to first column if missing
        if ($row.find('td input[type="checkbox"]').length === 0) {
            var $firstTd = $row.find('td:first');
            var $checkboxTd = $('<td class="text-center">' +
                '<div class="checkbox-enhanced">' +
                '<input type="checkbox" class="check-inputs form-check-input" value="">' +
                '<span class="checkmark"></span>' +
                '</div>' +
                '</td>');

            $firstTd.before($checkboxTd);
        }

        // Add action buttons if missing
        if ($row.find('.action-buttons, .btn-group').length === 0) {
            var $actionsTd = $('<td>' +
                '<div class="action-buttons">' +
                '<a href="#" class="btn-action edit" title="تعديل">' +
                '<i class="fas fa-edit"></i>' +
                '</a>' +
                '<button class="btn-action delete" title="حذف">' +
                '<i class="fas fa-trash"></i>' +
                '</button>' +
                '</div>' +
                '</td>');

            $row.append($actionsTd);
        }
    });
}

/**
 * Add Action Buttons If Missing
 */
function addActionButtonsIfMissing($table) {
    // This function ensures action buttons are present
    // Implementation depends on specific requirements
}

/**
 * Enhance Status Badges
 */
function enhanceStatusBadges($table) {
    $table.find('td').each(function () {
        var $td = $(this);
        var text = $td.text().trim();

        // Convert status text to badges
        if (text === 'نشط' || text === 'Active' || text === 'Yes' || text === 'نعم') {
            $td.html('<span class="status-badge active">' + text + '</span>');
        } else if (text === 'غير نشط' || text === 'Inactive' || text === 'No' || text === 'لا') {
            $td.html('<span class="status-badge inactive">' + text + '</span>');
        } else if (text === 'في الانتظار' || text === 'Pending') {
            $td.html('<span class="status-badge pending">' + text + '</span>');
        }
    });
}

/**
 * Initialize Universal Checkboxes
 */
function initializeUniversalCheckboxes() {
    // Handle "Select All" checkbox
    $(document).off('change', '#checkAll').on('change', '#checkAll', function () {
        var isChecked = $(this).is(':checked');
        $('.check-inputs').prop('checked', isChecked);
        updateCheckboxStyling();
    });

    // Handle individual checkboxes
    $(document).off('change', '.check-inputs').on('change', '.check-inputs', function () {
        var totalCheckboxes = $('.check-inputs').length;
        var checkedCheckboxes = $('.check-inputs:checked').length;
        $('#checkAll').prop('checked', totalCheckboxes === checkedCheckboxes);
        updateCheckboxStyling();
    });

    // Click handler for enhanced checkboxes
    $(document).off('click', '.checkbox-enhanced').on('click', '.checkbox-enhanced', function (e) {
        e.preventDefault();
        var checkbox = $(this).find('input[type="checkbox"]');
        var isChecked = checkbox.is(':checked');
        checkbox.prop('checked', !isChecked);

        if (checkbox.attr('id') === 'checkAll') {
            $('.check-inputs').prop('checked', !isChecked);
        } else {
            var totalCheckboxes = $('.check-inputs').length;
            var checkedCheckboxes = $('.check-inputs:checked').length;
            $('#checkAll').prop('checked', totalCheckboxes === checkedCheckboxes);
        }

        updateCheckboxStyling();
    });

    // Update checkbox styling
    function updateCheckboxStyling() {
        $('.check-inputs:checked').closest('.checkbox-enhanced').addClass('checked');
        $('.check-inputs:not(:checked)').closest('.checkbox-enhanced').removeClass('checked');

        if ($('#checkAll').is(':checked')) {
            $('#checkAll').closest('.checkbox-enhanced').addClass('checked');
        } else {
            $('#checkAll').closest('.checkbox-enhanced').removeClass('checked');
        }
    }

    // Initial styling update
    setTimeout(updateCheckboxStyling, 100);
}

/**
 * Auto-enhance new tables added dynamically
 */
$(document).on('DOMNodeInserted', function (e) {
    var $target = $(e.target);
    if ($target.is('table') || $target.find('table').length) {
        setTimeout(function () {
            enhanceAllTables();
        }, 100);
    }
});

/**
 * Re-initialize on DataTable redraw
 */
$(document).on('draw.dt', function () {
    setTimeout(function () {
        enhanceAllTables();
        initializeUniversalCheckboxes();
    }, 100);
});

/**
 * Re-initialize on page load
 */
$(window).on('load', function () {
    setTimeout(function () {
        enhanceAllTables();
        initializeUniversalCheckboxes();
    }, 1000);
});
