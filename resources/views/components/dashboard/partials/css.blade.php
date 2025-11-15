<!-- plugin css -->
<link href="{{ Path::dashboardPath('libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}"
    rel="stylesheet" type="text/css" />

<!-- preloader css -->
<link rel="stylesheet" href="{{ Path::dashboardPath('css/preloader.min.css') }}" type="text/css" />

<!-- choices css -->
<link href="{{ Path::dashboardPath('libs/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet"
    type="text/css" />

<!-- Bootstrap Css -->
@if(app()->getLocale() === 'ar')
<link href="{{ Path::dashboardPath('css/bootstrap-rtl.min.css') }}" id="bootstrap-style" rel="stylesheet"
    type="text/css" />
@else
<link href="{{ Path::dashboardPath('css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
@endif
<!-- Icons Css -->
<link href="{{ Path::dashboardPath('css/icons.min.css') }}" rel="stylesheet" type="text/css" />
<!-- App Css-->
@if(app()->getLocale() === 'ar')
<link href="{{ Path::dashboardPath('css/app-rtl.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
@else
<link href="{{ Path::dashboardPath('css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
@endif

<!-- Toastr -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- DataTables CSS -->
<link href="{{ Path::dashboardPath('libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
    type="text/css" />
<link href="{{ Path::dashboardPath('libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}"
    rel="stylesheet" type="text/css" />
<link href="{{ Path::dashboardPath('libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
    rel="stylesheet" type="text/css" />

<!-- Custom Dashboard CSS -->
<link href="{{ Path::dashboardPath('css/dashboard-tables.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ Path::dashboardPath('css/dashboard-forms.css') }}" rel="stylesheet" type="text/css" />

@if(app()->getLocale() === 'ar')
<!-- RTL Fixes -->
<style>
/* Fix table overflow in RTL */
.main-content {
    margin-right: 250px !important;
    margin-left: 0 !important;
}

/* Sidebar RTL positioning */
.vertical-menu {
    right: 0 !important;
    left: auto !important;
}

/* Table container RTL fixes */
.table-responsive {
    overflow-x: auto;
    direction: rtl;
}

.table-responsive table {
    direction: rtl;
}

/* DataTables RTL fixes */
.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter,
.dataTables_wrapper .dataTables_info,
.dataTables_wrapper .dataTables_paginate {
    direction: rtl;
    text-align: right;
}

/* Card body padding adjustment for RTL */
.card-body {
    padding-right: 1.5rem;
    padding-left: 1.5rem;
}

/* Button groups RTL */
.btn-group {
    direction: rtl;
}

/* Fix for collapsed sidebar */
body.sidebar-enable .main-content {
    margin-right: 70px !important;
    margin-left: 0 !important;
}

/* Topbar RTL adjustments */
.navbar-header {
    direction: rtl;
}

.navbar-header .d-flex {
    justify-content: space-between;
}

/* Dropdown RTL */
.dropdown-menu {
    right: 0;
    left: auto;
}
</style>
@endif