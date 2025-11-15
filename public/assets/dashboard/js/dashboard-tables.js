/**
 * Dashboard Tables Enhanced JavaScript
 * Provides enhanced functionality for dashboard tables with Arabic/English support
 */

$(document).ready(function () {
    // Initialize enhanced DataTables
    initializeEnhancedDataTables();

    // Initialize enhanced checkboxes with delay
    setTimeout(function () {
        initializeEnhancedCheckboxes();
    }, 500);

    // Initialize table animations
    initializeTableAnimations();
});

/**
 * Initialize Enhanced DataTables
 */
function initializeEnhancedDataTables() {
    if ($.fn.DataTable) {
        // Override default DataTable settings
        $.extend($.fn.dataTable.defaults, {
            "language": {
                "sProcessing": "جاري التحميل...",
                "sLengthMenu": "أظهر _MENU_ سجل",
                "sZeroRecords": "لم يعثر على أية سجلات",
                "sInfo": "إظهار _START_ إلى _END_ من أصل _TOTAL_ سجل",
                "sInfoEmpty": "يعرض 0 إلى 0 من أصل 0 سجل",
                "sInfoFiltered": "(منتقاة من مجموع _MAX_ سجل)",
                "sInfoPostFix": "",
                "sSearch": "بحث:",
                "sUrl": "",
                "oPaginate": {
                    "sFirst": "الأول",
                    "sPrevious": "السابق",
                    "sNext": "التالي",
                    "sLast": "الأخير"
                },
                "oAria": {
                    "sSortAscending": ": تفعيل لترتيب العمود تصاعدياً",
                    "sSortDescending": ": تفعيل لترتيب العمود تنازلياً"
                }
            },
            "dom": '<"row"<"col-md-6"B><"col-md-6"f>>' +
                '<"row"<"col-sm-12"tr>>' +
                '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            "buttons": [
                {
                    extend: 'copy',
                    className: 'btn-sm btn-outline-primary',
                    text: '<i class="fas fa-copy"></i> نسخ'
                },
                {
                    extend: 'excel',
                    className: 'btn-sm btn-outline-success',
                    text: '<i class="fas fa-file-excel"></i> Excel'
                },
                {
                    extend: 'pdf',
                    className: 'btn-sm btn-outline-danger',
                    text: '<i class="fas fa-file-pdf"></i> PDF'
                },
                {
                    extend: 'colvis',
                    className: 'btn-sm btn-outline-info',
                    text: '<i class="fas fa-columns"></i> الأعمدة'
                }
            ],
            "pageLength": 10,
            "processing": true,
            "responsive": true,
            "autoWidth": false,
            "drawCallback": function () {
                // Add enhanced styling to pagination
                $('.dataTables_paginate > .pagination').addClass('pagination-rounded');

                // Add loading animation
                $('.table-enhanced tbody tr').addClass('animate-fade-in');

                // Initialize tooltips for action buttons
                initializeTooltips();
            },
            "initComplete": function () {
                // Add loading state removal
                $('.table-loading').removeClass('table-loading');
            }
        });
    }
}

/**
 * Initialize Enhanced Checkboxes
 */
function initializeEnhancedCheckboxes() {
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
 * Initialize Table Animations
 */
function initializeTableAnimations() {
    // Add hover effects to table rows
    $('.table-enhanced tbody tr').hover(
        function () {
            $(this).addClass('table-row-hover');
        },
        function () {
            $(this).removeClass('table-row-hover');
        }
    );

    // Add click effects to action buttons
    $('.btn-action').on('click', function () {
        $(this).addClass('btn-action-clicked');
        setTimeout(() => {
            $(this).removeClass('btn-action-clicked');
        }, 200);
    });
}

/**
 * Initialize Tooltips
 */
function initializeTooltips() {
    if ($.fn.tooltip) {
        $('[title]').tooltip({
            placement: 'top',
            trigger: 'hover'
        });
    }
}

/**
 * Enhanced DataTable Initialization Function
 */
function initializeDataTable(tableId) {
    // Destroy existing DataTable if it exists
    if ($.fn.DataTable.isDataTable(tableId)) {
        $(tableId).DataTable().destroy();
    }

    // Remove existing buttons
    $('.dt-buttons').remove();

    // Add loading state
    $(tableId).closest('.dashboard-table-container').addClass('table-loading');

    // Initialize new DataTable
    var table = $(tableId).DataTable({
        "columnDefs": [{
            "targets": 0,
            "orderable": false,
            "searchable": false,
            "className": "text-center"
        }],
        "order": [[1, 'desc']],
        "drawCallback": function () {
            // Enhanced pagination styling
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');

            // Add row animations
            $('.table-enhanced tbody tr').each(function (index) {
                $(this).css('animation-delay', (index * 0.1) + 's');
            });

            // Initialize tooltips
            initializeTooltips();
        },
        "initComplete": function () {
            // Remove loading state
            $(tableId).closest('.dashboard-table-container').removeClass('table-loading');

            // Update button container styling
            var buttonsContainer = table.buttons().container();
            if (buttonsContainer.length) {
                buttonsContainer.removeClass('btn-group').addClass('text-end');
                buttonsContainer.appendTo(tableId + '_wrapper .col-md-6:eq(0)');

                // Add enhanced button styling
                buttonsContainer.find('.btn').addClass('btn-enhanced');
            }
        }
    });

    return table;
}

/**
 * Show/Hide Table Loading State
 */
function toggleTableLoading(tableId, show = true) {
    var container = $(tableId).closest('.dashboard-table-container');
    if (show) {
        container.addClass('table-loading');
    } else {
        container.removeClass('table-loading');
    }
}

/**
 * Add Row Animation
 */
function addRowAnimation() {
    $('.table-enhanced tbody tr').addClass('animate-fade-in');
}

/**
 * RTL Support Functions
 */
function initializeRTLSupport() {
    if ($('html').attr('dir') === 'rtl') {
        // Adjust DataTable pagination for RTL
        $('.dataTables_paginate').addClass('rtl-pagination');

        // Adjust button container for RTL
        $('.dt-buttons').addClass('rtl-buttons');

        // Adjust table header alignment
        $('.table-enhanced thead th').addClass('rtl-header');
    }
}

/**
 * Responsive Table Functions
 */
function handleResponsiveTables() {
    // Check if table is responsive
    if ($('.table-responsive').length) {
        $('.table-responsive').on('scroll', function () {
            // Add scroll indicator
            var scrollLeft = $(this).scrollLeft();
            var scrollWidth = $(this)[0].scrollWidth;
            var clientWidth = $(this)[0].clientWidth;

            if (scrollLeft > 0) {
                $(this).addClass('scrolled-left');
            } else {
                $(this).removeClass('scrolled-left');
            }

            if (scrollLeft < scrollWidth - clientWidth) {
                $(this).addClass('can-scroll-right');
            } else {
                $(this).removeClass('can-scroll-right');
            }
        });
    }
}

/**
 * Export Functions
 */
function exportTableData(tableId, format) {
    var table = $(tableId).DataTable();

    switch (format) {
        case 'excel':
            table.button('.buttons-excel').trigger();
            break;
        case 'pdf':
            table.button('.buttons-pdf').trigger();
            break;
        case 'copy':
            table.button('.buttons-copy').trigger();
            break;
    }
}

/**
 * Search Functions
 */
function performTableSearch(tableId, searchTerm) {
    var table = $(tableId).DataTable();
    table.search(searchTerm).draw();
}

/**
 * Column Visibility Functions
 */
function toggleColumnVisibility(tableId, columnIndex, visible) {
    var table = $(tableId).DataTable();
    table.column(columnIndex).visible(visible);
}

/**
 * Row Selection Functions
 */
function getSelectedRows() {
    var selectedIds = [];
    $('.check-inputs:checked').each(function () {
        selectedIds.push($(this).val());
    });
    return selectedIds;
}

function selectAllRows(tableId) {
    $('#checkAll').prop('checked', true).trigger('change');
}

function deselectAllRows() {
    $('#checkAll').prop('checked', false).trigger('change');
}

// Initialize everything when document is ready
$(document).ready(function () {
    initializeRTLSupport();
    handleResponsiveTables();
});
