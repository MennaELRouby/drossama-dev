<x-dashboard.layout title="Enhanced Tables Example">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Enhanced Tables Example</h4>
                    <div class="page-title-right">
                        <button class="btn btn-primary" onclick="toggleTheme()">
                            <i class="fas fa-palette"></i> Toggle Theme
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Arabic Table Example -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="dashboard-table-container">
                    <div class="card-header">
                        <h4>جدول الأرقام - Arabic Table</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="arabic-table" class="table-enhanced table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 50px;">
                                            <div class="checkbox-enhanced">
                                                <input type="checkbox" id="checkAllArabic">
                                                <span class="checkmark"></span>
                                            </div>
                                        </th>
                                        <th>الرقم</th>
                                        <th>الاسم بالعربية</th>
                                        <th>الاسم بالإنجليزية</th>
                                        <th>البريد الإلكتروني</th>
                                        <th>رقم الهاتف</th>
                                        <th>الحالة</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">
                                            <div class="checkbox-enhanced">
                                                <input type="checkbox" class="check-inputs" value="1">
                                                <span class="checkmark"></span>
                                            </div>
                                        </td>
                                        <td>1</td>
                                        <td>أحمد محمد</td>
                                        <td>Ahmed Mohamed</td>
                                        <td>ahmed@example.com</td>
                                        <td>+201234567890</td>
                                        <td><span class="status-badge active">نشط</span></td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="#" class="btn-action edit" title="تعديل">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="#" class="btn-action view" title="عرض">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button class="btn-action delete" title="حذف">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <div class="checkbox-enhanced">
                                                <input type="checkbox" class="check-inputs" value="2">
                                                <span class="checkmark"></span>
                                            </div>
                                        </td>
                                        <td>2</td>
                                        <td>فاطمة علي</td>
                                        <td>Fatma Ali</td>
                                        <td>fatma@example.com</td>
                                        <td>+201234567891</td>
                                        <td><span class="status-badge inactive">غير نشط</span></td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="#" class="btn-action edit" title="تعديل">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="#" class="btn-action view" title="عرض">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button class="btn-action delete" title="حذف">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <div class="checkbox-enhanced">
                                                <input type="checkbox" class="check-inputs" value="3">
                                                <span class="checkmark"></span>
                                            </div>
                                        </td>
                                        <td>3</td>
                                        <td>محمد حسن</td>
                                        <td>Mohamed Hassan</td>
                                        <td>mohamed@example.com</td>
                                        <td>+201234567892</td>
                                        <td><span class="status-badge pending">في الانتظار</span></td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="#" class="btn-action edit" title="تعديل">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="#" class="btn-action view" title="عرض">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button class="btn-action delete" title="حذف">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- English Table Example -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="dashboard-table-container">
                    <div class="card-header">
                        <h4>Products Table - English Table</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="english-table" class="table-enhanced table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 50px;">
                                            <div class="checkbox-enhanced">
                                                <input type="checkbox" id="checkAllEnglish">
                                                <span class="checkmark"></span>
                                            </div>
                                        </th>
                                        <th>ID</th>
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">
                                            <div class="checkbox-enhanced">
                                                <input type="checkbox" class="check-inputs" value="1">
                                                <span class="checkmark"></span>
                                            </div>
                                        </td>
                                        <td>001</td>
                                        <td>Laptop Computer</td>
                                        <td>Electronics</td>
                                        <td>$999.99</td>
                                        <td>15</td>
                                        <td><span class="status-badge active">Active</span></td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="#" class="btn-action edit" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="#" class="btn-action view" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button class="btn-action delete" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <div class="checkbox-enhanced">
                                                <input type="checkbox" class="check-inputs" value="2">
                                                <span class="checkmark"></span>
                                            </div>
                                        </td>
                                        <td>002</td>
                                        <td>Smartphone</td>
                                        <td>Electronics</td>
                                        <td>$699.99</td>
                                        <td>0</td>
                                        <td><span class="status-badge inactive">Out of Stock</span></td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="#" class="btn-action edit" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="#" class="btn-action view" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button class="btn-action delete" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <div class="checkbox-enhanced">
                                                <input type="checkbox" class="check-inputs" value="3">
                                                <span class="checkmark"></span>
                                            </div>
                                        </td>
                                        <td>003</td>
                                        <td>Office Chair</td>
                                        <td>Furniture</td>
                                        <td>$299.99</td>
                                        <td>8</td>
                                        <td><span class="status-badge pending">Pending</span></td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="#" class="btn-action edit" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="#" class="btn-action view" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button class="btn-action delete" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty State Example -->
        <div class="row">
            <div class="col-12">
                <div class="dashboard-table-container">
                    <div class="card-header">
                        <h4>Empty State Example</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="empty-table" class="table-enhanced table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="4" class="table-empty">
                                            <i class="fas fa-database"></i>
                                            <h5>No Data Available</h5>
                                            <p>There are no records to display at this time.</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Initialize Arabic table
                var arabicTable = initializeDataTable('#arabic-table');

                // Initialize English table
                var englishTable = initializeDataTable('#english-table');

                // Initialize empty table (no DataTable needed)

                // Demo functions
                window.toggleTheme = function() {
                    $('html').toggleClass('dark-theme');
                };

                // Add some demo interactions
                $('.btn-action.delete').on('click', function() {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            );
                        }
                    });
                });
            });
        </script>
    @endpush
</x-dashboard.layout>
