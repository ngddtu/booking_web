<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Admin Template - Demo</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
        }

        /* Sidebar Styling */
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
            color: #fff;
            width: 250px;
            position: fixed;
            transition: all 0.3s;
            z-index: 1000;
        }

        .sidebar .nav-link {
            color: #c2c7d0;
            padding: 10px 15px;
            margin-bottom: 5px;
            border-radius: 4px;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #007bff;
            color: #fff;
        }

        .sidebar .nav-header {
            font-size: 0.85rem;
            text-transform: uppercase;
            color: #6c757d;
            padding: 10px 15px;
            font-weight: bold;
        }

        .sidebar .brand {
            padding: 15px;
            border-bottom: 1px solid #4b545c;
            font-size: 1.25rem;
            font-weight: bold;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s;
        }

        /* Room Card Styling */
        .room-card {
            cursor: pointer;
            transition: transform 0.2s;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .room-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .status-strip {
            height: 5px;
            width: 100%;
            position: absolute;
            top: 0;
            left: 0;
        }

        /* Status Colors */
        .bg-available {
            background-color: #28a745;
        }

        /* Trống */
        .bg-occupied {
            background-color: #dc3545;
        }

        /* Đang ở */
        .bg-dirty {
            background-color: #ffc107;
        }

        /* Bẩn */
        .bg-reserved {
            background-color: #17a2b8;
        }

        /* Đặt trước */

        /* Utility */
        .card-icon {
            font-size: 2.5rem;
            opacity: 0.2;
            position: absolute;
            right: 15px;
            bottom: 10px;
        }

        .section-view {
            display: none;
        }

        /* Show active section */
        .section-view.active {
            display: block;
        }
    </style>
</head>

<body>

    <!-- 1. SIDEBAR -->
    <aside class="sidebar d-flex flex-column">
        <div class="brand">
            <i class="fas fa-hotel me-2"></i> PMS System
        </div>

        <!-- User Info (Static) -->
        <div class="p-3 border-bottom border-secondary d-flex align-items-center">
            <img src="https://ui-avatars.com/api/?name=Admin+User&background=random" class="rounded-circle me-2"
                width="35">
            <div>
                <div class="fw-bold">{{ auth()->user()->name }}</div>
                <small class="text-secondary"><i class="fas fa-circle text-success font-10"></i> Online</small>
            </div>
        </div>

        <nav class="nav flex-column p-2 flex-grow-1">

            <!-- Dashboard -->
            <a href="#" class="nav-link" onclick="switchView('dashboard', this)">
                <i class="fas fa-tachometer-alt me-2 text-center" style="width:20px"></i> Tổng quan
            </a>

            <!-- SALE SECTION -->
            <div class="nav-header mt-2">Lễ Tân (Sale)</div>
            <a href="{{ route('reserve.manage_reserve') }}" class="nav-link ">
                <i class="fas fa-th me-2 text-center" style="width:20px"></i> Sơ đồ phòng
            </a>
            <a href="#" class="nav-link" onclick="switchView('bookings', this)">
                <i class="fas fa-calendar-check me-2 text-center" style="width:20px"></i> DS Đặt phòng
            </a>
            <a href="{{ route('customer.manage-customer') }}" class="nav-link" onclick="switchView('customers', this)">
                <i class="fas fa-users me-2 text-center" style="width:20px"></i> Khách hàng
            </a>

            <!-- MANAGER SECTION -->
            <div class="nav-header mt-2">Quản Trị (Manager)</div>
            <a href="{{ route('room.manage-room') }}" class="nav-link">
                <i class="fas fa-bed me-2 text-center" style="width:20px"></i> Quản lý Phòng
            </a>
            <!-- MỚI THÊM: Quản lý loại phòng -->
            <a href="{{ route('room.manage-type-room') }}" class="nav-link">
                <i class="fas fa-shapes me-2 text-center" style="width:20px"></i> QL Loại phòng
            </a>
            <a href="{{ route('room.manage-services') }}" class="nav-link">
                <i class="fas fa-coffee me-2 text-center" style="width:20px"></i> Quản lý Dịch vụ
            </a>
            <a href="#" class="nav-link">
                <i class="fas fa-user-cog me-2 text-center" style="width:20px"></i> Nhân viên
            </a>
        </nav>

        <div class="p-3">
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger w-100 btn-sm"><i class="fas fa-sign-out-alt"></i> Đăng xuất</button>
            </form>
            {{-- <a href="/logout" class="btn btn-danger w-100 btn-sm"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a> --}}
        </div>
    </aside>
    <!-- MAIN CONTENT WRAPPER -->
    <main class="main-content">

        <!-- Top Navbar -->
        <nav class="navbar navbar-light bg-white shadow-sm mb-4 rounded px-3">
            <div class="d-flex justify-content-between w-100 align-items-center">
                <h5 class="m-0 text-dark fw-bold">@yield('title')</h5>
                <div>
                    <button class="btn btn-outline-primary btn-sm me-2"><i class="fas fa-bell"></i> <span
                            class="badge bg-danger">3</span></button>
                    <button class="btn btn-outline-secondary btn-sm"><i class="fas fa-cog"></i></button>
                </div>
            </div>
        </nav>

        <!-- CONTENT INJECTION POINT -->
        <div id="content-area">
            <!-- Nội dung các file con sẽ được đặt vào đây -->
            @yield('content')
            <!-- Ví dụ: Nếu mở file dashboard.html, nội dung dashboard sẽ nằm ở đây -->
        </div>

    </main>

    <!-- GLOBAL MODALS (Đặt ở đây để trang nào cũng gọi được nếu cần) -->
    <!-- Modal Check-in -->
    {{-- <div class="modal fade" id="checkinModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Nhận phòng - P.101</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Form Check-in Content -->
                    <p>Nội dung form check-in (như đã thiết kế)...</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button class="btn btn-success">Lưu</button>
                </div>
            </div>
        </div>
    </div> --}}


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('script')

    <!-- SCRIPTS -->

    <script>
        // Hàm mở modal demo
        function openModal(id) {
            var myModal = new bootstrap.Modal(document.getElementById(id));
            myModal.show();
        }
    </script>

</body>

</html>
