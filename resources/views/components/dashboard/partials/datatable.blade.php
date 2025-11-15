<script>
    function initializeDataTable(tableId) {
        // تدمير الجدول إذا كان موجوداً
        if ($.fn.DataTable.isDataTable(tableId)) {
            $(tableId).DataTable().destroy();
        }

        // إزالة أي أزرار موجودة
        $('.dt-buttons').remove();

        // إعادة تهيئة الجدول
        var table = $(tableId).DataTable({
            dom: '<"row"<"col-md-6"B><"col-md-6"f>>' +
                '<"row"<"col-sm-12"tr>>' +
                '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            buttons: [{
                    extend: 'copy',
                    className: 'btn-sm'
                },
                {
                    extend: 'excel',
                    className: 'btn-sm'
                },
                {
                    extend: 'pdf',
                    className: 'btn-sm'
                },
                {
                    extend: 'colvis',
                    className: 'btn-sm'
                }
            ],
            pageLength: 10,
            processing: true,
            columnDefs: [{
                targets: 0,
                orderable: false,
                searchable: false,
                className: 'text-center'
            }],
            order: [
                [1, 'desc']
            ],
            language: {
                paginate: {
                    previous: "<i class='mdi mdi-chevron-left'>",
                    next: "<i class='mdi mdi-chevron-right'>"
                },
                search: "بحث:",
                lengthMenu: "عرض _MENU_ سجلات",
                info: "عرض _START_ إلى _END_ من _TOTAL_ سجل",
                infoEmpty: "لا توجد سجلات متاحة",
                infoFiltered: "(تمت التصفية من _MAX_ سجل)",
                zeroRecords: "لا توجد سجلات مطابقة",
                emptyTable: "لا توجد بيانات متاحة في الجدول"
            },
            drawCallback: function() {
                $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
            }
        });

        // تحديث عرض الأزرار
        var buttonsContainer = table.buttons().container();
        if (buttonsContainer.length) {
            buttonsContainer.removeClass('btn-group').addClass('text-end');
            buttonsContainer.appendTo(tableId + '_wrapper .col-md-6:eq(0)');
        }

        return table;
    }
</script>
