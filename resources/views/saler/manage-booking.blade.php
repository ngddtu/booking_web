@extends('components.layout')

@section('title', 'Sơ đồ phòng')

@section('content')
    <!-- VIEW 2: PROFESSIONAL ROOM PLAN -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
            <i class="fas fa-times-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div id="room-plan" class="section-view active">

        <!-- 1. DASHBOARD MINI (Thống kê nhanh) -->
        <div class="row g-3 mb-3">
            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm bg-white">
                    <div class="card-body p-2 d-flex align-items-center">
                        <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                            <i class="fas fa-door-open text-success fa-lg"></i>
                        </div>
                        <div>
                            <div class="small text-muted fw-bold">Sẵn sàng đón</div>
                            <h4 class="mb-0 fw-bold text-dark">{{ $status['available'] }}<span class="text-muted fs-6 font-weight-normal">/
                                    {{ $status['total'] }}</span></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm bg-white">
                    <div class="card-body p-2 d-flex align-items-center">
                        <div class="rounded-circle bg-danger bg-opacity-10 p-3 me-3">
                            <i class="fas fa-user-check text-danger fa-lg"></i>
                        </div>
                        <div>
                            <div class="small text-muted fw-bold">Đang có khách</div>
                            <h4 class="mb-0 fw-bold text-dark">{{ $status['occupied'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm bg-white">
                    <div class="card-body p-2 d-flex align-items-center">
                        <div class="rounded-circle bg-warning bg-opacity-10 p-3 me-3">
                            <i class="fas fa-broom text-warning fa-lg"></i>
                        </div>
                        <div>
                            <div class="small text-muted fw-bold">Cần dọn dẹp</div>
                            <h4 class="mb-0 fw-bold text-dark">{{ $status['cleaning'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm bg-white">
                    <div class="card-body p-2 d-flex align-items-center">
                        <div class="rounded-circle bg-info bg-opacity-10 p-3 me-3">
                            <i class="fas fa-clock text-info fa-lg"></i>
                        </div>
                        <div>
                            <div class="small text-muted fw-bold">Khách sắp đến</div>
                            <h4 class="mb-0 fw-bold text-dark">1</h4>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>

        <!-- 2. THANH CÔNG CỤ TÌM KIẾM & LỌC (ADVANCED FILTER) -->
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body py-2">
                <div class="row g-2 align-items-center">
                    <!-- Tìm kiếm -->
                    <div class="col-lg-3 col-md-4">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-white border-end-0"><i
                                    class="fas fa-search text-muted"></i></span>
                            <input type="text" id="searchInput" class="form-control border-start-0"
                                placeholder="Tìm số phòng, tên khách..." onkeyup="filterRooms()">
                        </div>
                    </div>

                    <!-- Bộ lọc Loại phòng -->
                    {{-- <div class="col-lg-2 col-md-3">
                        <select id="typeFilter" class="form-select form-select-sm" onchange="filterRooms()">
                            <option value="all">-- Tất cả loại --</option>
                            <option value="Đơn">Phòng Đơn</option>
                            <option value="Đôi">Phòng Đôi</option>
                            <option value="VIP">Phòng VIP</option>
                        </select>
                    </div> --}}

                    <!-- Bộ lọc Tầng -->
                    <div class="col-lg-2 col-md-3">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-white border-end-0"><i
                                    class="fas fa-search text-muted"></i></span>
                            <input type="text" id="floorInput" class="form-control border-start-0"
                                placeholder="Tầng thứ..." onkeyup="filterRooms()">
                        </div>
                    </div>

                    <!-- Filter Button Group (Trạng thái) -->
                    <div class="col-lg-5 col-md-12 text-md-end text-start">
                        <div class="btn-group btn-group-sm w-100 w-md-auto" role="group">
                            <input type="radio" class="btn-check" name="statusRadio" id="stAll" autocomplete="off"
                                checked onclick="filterStatus('all')">
                            <label class="btn btn-outline-secondary" for="stAll">Tất cả</label>

                            <input type="radio" class="btn-check" name="statusRadio" id="stAvail" autocomplete="off"
                                onclick="filterStatus('available')">
                            <label class="btn btn-outline-success" for="stAvail">Trống</label>

                            <input type="radio" class="btn-check" name="statusRadio" id="stOcc" autocomplete="off"
                                onclick="filterStatus('occupied')">
                            <label class="btn btn-outline-danger" for="stOcc">Đang ở</label>

                            <input type="radio" class="btn-check" name="statusRadio" id="stDirty" autocomplete="off"
                                onclick="filterStatus('dirty')">
                            <label class="btn btn-outline-warning" for="stDirty">Bẩn</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row g-3" id="roomGrid">

            {{-- Vòng lặp foreach thần thánh nằm ở đây --}}
            @foreach ($rooms as $room)
                {{-- Truyền từng đối tượng $room đơn lẻ vào Component --}}
                <x-room-card :room="$room" />
            @endforeach

        </div>
    </div>
    {{-- Modal --}}

    <!-- MODAL: CHECK-IN CHUYÊN NGHIỆP -->
    <div class="modal fade" id="checkinModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl"> <!-- Dùng modal-xl cho rộng rãi -->
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-key me-2"></i> NHẬN PHÒNG - <span id="modalRoomTitle"
                            class="badge bg-white text-success fs-6">101</span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('booking.store') }}" method="POST" id="checkinForm">
                    @csrf
                    <input type="hidden" name="room_id" id="checkinRoomId">
                    <div class="modal-body bg-light">
                        <div class="row g-0">

                            <!-- CỘT TRÁI: THÔNG TIN KHÁCH HÀNG (QUAN TRỌNG) -->
                            <div class="col-lg-5 pe-lg-3 border-end">
                                <div class="card shadow-sm border-0 mb-3">
                                    <div class="card-header bg-white fw-bold text-success">
                                        <i class="fas fa-user-check"></i> 1. Định danh Khách hàng
                                    </div>
                                    <div class="card-body">
                                        <!-- Thanh tìm kiếm -->
                                        <label class="form-label small fw-bold text-muted">Tìm khách cũ (SĐT/CCCD)</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="searchGuestInput" name="phone_search"
                                                class="form-control" placeholder="Nhập số điện thoại...">
                                            <button class="btn btn-primary" type="button"
                                                onclick="simulateSearchGuest()">
                                                <i class="fas fa-search"></i> Tìm
                                            </button>
                                        </div>

                                        <!-- Khu vực hiển thị kết quả tìm kiếm (Mặc định ẩn) -->
                                        <div id="guestFoundAlert"
                                            class="alert alert-info d-flex align-items-center d-none" role="alert">
                                            <i class="fas fa-check-circle fa-2x me-3"></i>
                                            <div>
                                                <div class="fw-bold">Nguyễn Văn A <span
                                                        class="badge bg-warning text-dark ms-1">VIP Gold</span></div>
                                                <div class="small">0909.123.456 - Đã ở 12 lần</div>
                                            </div>
                                            <button class="btn btn-sm btn-light ms-auto fw-bold text-primary">Dùng</button>
                                        </div>

                                        <hr class="text-muted opacity-25">

                                        <!-- Form thông tin chi tiết -->
                                        <div class="row g-2">
                                            <div class="col-md-8">
                                                <label class="form-label small text-muted">Họ và tên <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-sm fw-bold"
                                                    id="guestName" name="name" placeholder="VD: Tran Van B" required>
                                            </div>
                                            <input type="text" name="customer_id" hidden>
                                            <div class="col-md-4">
                                                <label class="form-label small text-muted">Giới tính</label>
                                                <select class="form-select form-select-sm" name="gender">
                                                    <option value="male">Nam</option>
                                                    <option value="female">Nữ</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small text-muted">Số điện thoại</label>
                                                <input type="text" class="form-control form-control-sm" name="phone"
                                                    id="guestPhone">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small text-muted">Số CCCD/Hộ chiếu</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    name="citizen_id">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small text-muted">Quốc tịch</label>
                                                <select class="form-select form-select-sm" name="nationality">
                                                    <option value="Vietnam">Việt Nam</option>
                                                    <option value="International">Quốc tế...</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label small text-muted">Địa chỉ (Tùy chọn)</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    placeholder="Ghi chú địa chỉ..." name="address">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- CỘT PHẢI: THÔNG TIN THUÊ & THANH TOÁN -->
                            <div class="col-lg-7 ps-lg-3">
                                <div class="card shadow-sm border-0 h-100">
                                    <div class="card-header bg-white fw-bold text-success">
                                        <i class="fas fa-clock"></i> 2. Chi tiết Thuê & Đặt cọc
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <!-- Loại hình thuê -->
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold small">Hình thức thuê</label>
                                                <div class="btn-group w-100" role="group">
                                                    <input type="radio" class="btn-check" name="rent_type"
                                                        id="typeHour" value="hourly" autocomplete="off" checked>
                                                    <label class="btn btn-outline-secondary btn-sm" for="typeHour">Theo
                                                        giờ</label>

                                                    <input type="radio" class="btn-check" name="rent_type"
                                                        id="typeNight" value="overnight" autocomplete="off">
                                                    <label class="btn btn-outline-secondary btn-sm" for="typeNight">Qua
                                                        đêm</label>

                                                    <input type="radio" class="btn-check" name="rent_type"
                                                        id="typeDay" value="daily" autocomplete="off">
                                                    <label class="btn btn-outline-secondary btn-sm" for="typeDay">Theo
                                                        ngày</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label fw-bold small">Số người</label>

                                                <div class="input-group input-group-sm people-count-box">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-users"></i>
                                                    </span>

                                                    <div id="people_count"
                                                        class="form-control bg-light fw-bold text-center">
                                                        
                                                    </div>

                                                    <span class="input-group-text">Người</span>
                                                </div>
                                            </div>


                                            <!-- Thời gian -->
                                            <div class="col-md-6">
                                                <label class="form-label small text-muted">Thời gian vào (Check-in)</label>
                                                <input type="datetime-local" class="form-control form-control-sm"
                                                    value="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}"
                                                    name="check_in">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small text-muted">Dự kiến ra (Check-out)</label>
                                                <input type="datetime-local" class="form-control form-control-sm bg-light"
                                                    name="check_out">
                                            </div>

                                            <!-- Tài chính -->
                                            <div class="col-12 mt-4">
                                                <div class="bg-light p-3 rounded border border-success border-opacity-25">
                                                    <div class="row align-items-end">
                                                        <div class="col-md-4">
                                                            <label class="form-label small fw-bold">Giá phòng niêm
                                                                yết</label>
                                                                <div class="input-group input-group-sm">
                                                                <input type="text" id="roomListedPrice"
                                                                    class="form-control fw-bold text-dark" value="0"
                                                                    readonly name="total_price">
                                                                <span class="input-group-text">₫</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label small fw-bold text-primary">Tiền trả
                                                                trước
                                                                / Cọc</label>
                                                            <div class="input-group input-group-sm">
                                                                <input type="text"
                                                                    class="form-control fw-bold text-primary"
                                                                    placeholder="0" name="diposit">
                                                                <span class="input-group-text">₫</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label small fw-bold">Phương thức</label>
                                                            <select class="form-select form-select-sm"
                                                                name="deposit_method">
                                                                <option value="cash">Tiền mặt</option>
                                                                <option value="transfer">Chuyển khoản</option>
                                                                <option value="card">Thẻ</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label small text-muted">Ghi chú (Yêu cầu đặc
                                                    biệt)</label>
                                                <textarea class="form-control form-control-sm" rows="2" placeholder="VD: Khách cần mượn bàn ủi..."
                                                    name="note"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between bg-white">
                        <div class="text-muted small">
                            <i class="fas fa-info-circle"></i> Kiểm tra kỹ CCCD trước khi nhận khách.
                        </div>
                        <div>
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Hủy bỏ</button>
                            <button type="submit" class="btn btn-success fw-bold px-4"><i class="fas fa-check"></i> XÁC
                                NHẬN
                                NHẬN PHÒNG</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL: THÊM DỊCH VỤ (POS MINI) -->
    <div class="modal fade" id="addServiceModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content h-100">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-utensils me-2"></i> THÊM DỊCH VỤ - P.<span id="serviceRoomTitle">102</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="row g-0 h-100" style="min-height: 500px;">

                        <!-- CỘT TRÁI: MENU CHỌN MÓN -->
                        <div class="col-lg-7 border-end bg-light p-3">
                            <!-- Tìm kiếm món -->
                            <div class="input-group mb-3">
                                <span class="input-group-text bg-white border-end-0"><i class="fas fa-search"></i></span>
                                <input type="text" class="form-control border-start-0"
                                    placeholder="Tìm tên đồ uống, món ăn, dịch vụ...">
                            </div>

                            <!-- Danh sách Tabs Categories -->
                            {{-- <ul class="nav nav-pills mb-3 gap-2">
                                <li class="nav-item"><a class="nav-link active py-1 px-3 btn-sm" href="#">Tất
                                        cả</a></li>
                                <li class="nav-item"><a class="nav-link bg-white text-dark border py-1 px-3 btn-sm"
                                        href="#">Đồ uống</a></li>
                                <li class="nav-item"><a class="nav-link bg-white text-dark border py-1 px-3 btn-sm"
                                        href="#">Đồ ăn</a></li>
                                <li class="nav-item"><a class="nav-link bg-white text-dark border py-1 px-3 btn-sm"
                                        href="#">Giặt ủi</a></li>
                            </ul> --}}

                            <!-- Grid Món ăn -->
                            <div id="menuService" class="row g-2 overflow-auto" style="max-height: 400px;">

                            </div>
                        </div>

                        <!-- CỘT PHẢI: GIỎ HÀNG (ORDER) -->
                        <div class="col-lg-5 p-3 d-flex flex-column bg-white">
                            <h6 class="fw-bold border-bottom pb-2 mb-3">Danh sách đã chọn</h6>

                            <!-- List Items -->
                            <div class="flex-grow-1 overflow-auto mb-3">
                                <table class="table table-sm align-middle">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Tên món</th>
                                            <th class="text-center" style="width: 80px;">SL</th>
                                            <th class="text-end">Thành tiền</th>
                                            <th style="width: 30px;"></th>
                                        </tr>
                                    </thead>
                                    <form id="servicesForm" method="post">
                                        @method('PUT')
                                        @csrf
                                        <input type="hidden" name="services" id="servicesInput">
                                        <tbody id="tbodyServices">

                                            {{-- danh sách các món đã gọi --}}
                                        </tbody>
                                </table>
                            </div>

                            <!-- Tổng tiền & Action -->
                            <div class="bg-light p-3 rounded" id="totalServicePrice">

                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL: CHECK-OUT & THANH TOÁN (FINAL INVOICE) -->
    <div class="modal fade" id="checkoutModal" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-white border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold text-dark">
                        <i class="fas fa-file-invoice-dollar text-primary me-2"></i> Xác nhận Trả phòng & Thanh toán
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form id="checkoutForm" method="POST" action="">
                    @csrf
                    <div class="modal-body bg-light">
                        <div class="row h-100">

                            <!-- PHẦN 1: PREVIEW HÓA ĐƠN (LEFT SIDE) -->
                            <div class="col-lg-8 mb-3 mb-lg-0">
                                <div class="card shadow-sm border-0 h-100 receipt-paper">
                                    <div class="card-body p-4 position-relative">
                                        <!-- Invoice Header -->
                                        <div class="d-flex justify-content-between mb-4 border-bottom pb-3">
                                            <div>
                                                <h4 class="fw-bold text-uppercase text-primary mb-1">PMS HOTEL</h4>
                                                <small class="text-muted">123 Đường ABC, Quận 1, TP.HCM</small><br>
                                                <small class="text-muted">Hotline: 1900 1000</small>
                                            </div>
                                            <div class="text-end">
                                                <h5 class="fw-bold">HÓA ĐƠN GTGT</h5>
                                                <div class="text-muted small">Ngày lập: <span id="invoiceDate"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Guest & Booking Info -->
                                        <div class="row mb-4 small">
                                            <div class="col-6">
                                                <label class="text-muted fw-bold">Khách hàng:</label>
                                                <div class="fw-bold fs-6" id="coCustomerName"></div>
                                                <div id="coCustomerPhone"></div>
                                            </div>
                                            <div class="col-6 text-end">
                                                <label class="text-muted fw-bold">Thông tin phòng:</label>
                                                <div class="fw-bold fs-6 badge bg-primary" id="coRoomInfo"></div>
                                                <div id="coCheckInTime"></div>
                                                <div id="coCheckOutTime"></div>
                                                <div id="realTime"></div>
                                            </div>
                                        </div>

                                        <!-- Chi tiết thanh toán -->
                                        <div class="table-responsive mb-3">
                                            <table class="table table-sm table-striped border-top">
                                                <thead class="bg-light text-secondary">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Hạng mục</th>
                                                        <th class="text-center">SL / TG</th>
                                                        <th class="text-end">Đơn giá</th>
                                                        <th class="text-end">Thành tiền</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="coInvoiceBody">
                                                    <!-- Generated via JS -->
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Tổng kết số tiền -->
                                        <div class="row justify-content-end">
                                            <div class="col-md-6">
                                                <table class="table table-borderless table-sm text-end">
                                                    <tr>
                                                        <td class="text-muted">Tổng dịch vụ:</td>
                                                        <td class="fw-bold" id="coServiceTotal">0 ₫</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">Tiền phòng:</td>
                                                        <td class="fw-bold" id="coRoomTotal">0 ₫</td>
                                                    </tr>
                                                    <tr class="border-top border-2 border-dark">
                                                        <td class="pt-2 fs-5 fw-bold">CẦN THANH TOÁN:</td>
                                                        <td class="pt-2 fs-4 fw-bold text-danger" id="coFinalTotal">0 ₫
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- PHẦN 2: THANH TOÁN (RIGHT SIDE) -->
                            <div class="col-lg-4">
                                <div class="card shadow-sm border-0 h-100">
                                    <div class="card-header bg-primary text-white text-center py-3">
                                        <span class="small opacity-75 text-uppercase">Tổng tiền phải thu</span>
                                        <h2 class="fw-bold m-0" id="coDisplayTotal">0 ₫</h2>
                                    </div>
                                    <div class="card-body d-flex flex-column">

                                        <!-- Chọn phương thức thanh toán -->
                                        <div class="mb-4">
                                            <label class="form-label fw-bold small text-muted text-uppercase mb-2">Phương
                                                thức
                                                thanh toán</label>
                                            <div class="d-grid gap-2">
                                                <input type="radio" class="btn-check" name="payment_id" id="pay_cash"
                                                    value="1" checked>
                                                <label
                                                    class="btn btn-outline-secondary text-start d-flex justify-content-between align-items-center"
                                                    for="pay_cash">
                                                    <span><i class="fas fa-money-bill-wave me-2 text-success"></i> Tiền
                                                        mặt</span>
                                                    <i class="fas fa-check-circle check-icon"></i>
                                                </label>

                                                <input type="radio" class="btn-check" name="payment_id"
                                                    id="pay_transfer" value="2">
                                                <label
                                                    class="btn btn-outline-secondary text-start d-flex justify-content-between align-items-center"
                                                    for="pay_transfer">
                                                    <span><i class="fas fa-university me-2 text-primary"></i> Chuyển
                                                        khoản</span>
                                                    <i class="fas fa-check-circle check-icon"></i>
                                                </label>

                                                <input type="radio" class="btn-check" name="payment_id" id="pay_card"
                                                    value="3">
                                                <label
                                                    class="btn btn-outline-secondary text-start d-flex justify-content-between align-items-center"
                                                    for="pay_card">
                                                    <span><i class="fas fa-credit-card me-2 text-warning"></i> Thẻ tín
                                                        dụng</span>
                                                    <i class="fas fa-check-circle check-icon"></i>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label small text-muted">Ghi chú hóa đơn</label>
                                            <textarea class="form-control" rows="2" name="note" placeholder="VD: Khách quên sạc..."></textarea>
                                        </div>

                                        <div class="mt-auto gap-2 d-grid">
                                            <button type="submit" class="btn btn-success btn-lg fw-bold shadow-sm">
                                                <i class="fas fa-check-double"></i> HOÀN TẤT & TRẢ PHÒNG
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary"
                                                data-bs-dismiss="modal">
                                                Quay lại
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="listBookingModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-calendar-check text-primary me-2"></i>Chọn đơn để nhận phòng
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body" id="checkinModalBody">
                    <!-- Render by JS -->
                </div>
            </div>
        </div>
    </div>


    <form id="confirmCheckinForm" method="POST" style="display: none;">
        @csrf
    </form>

    <form id="rejectCheckinForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>



    <style>
        /* Custom CSS cho Room Plan Mới */
        .hover-shadow:hover {
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
            background-color: #fff !important;
            transition: all 0.2s;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .room-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .room-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }


        /* Hiệu ứng tờ hóa đơn giấy */
        .receipt-paper {
            background-color: #fff;
            border: 1px solid #e0e0e0;
            /* Hiệu ứng răng cưa dưới đáy hóa đơn (Optional) */
            mask-image: radial-gradient(circle at 10px bottom, transparent 10px, black 11px);
            mask-position: bottom;
            mask-size: 100% 100%;
        }

        /* Style cho nút chọn thanh toán */
        .btn-check:checked+.btn-outline-secondary {
            background-color: #f8f9fa;
            color: #000;
            border-color: #0d6efd;
            border-width: 2px;
        }

        .check-icon {
            display: none;
        }

        .btn-check:checked+.btn-outline-secondary .check-icon {
            display: inline-block;
            color: #0d6efd;
        }
        
        .people-count-box .form-control {
        display: flex;
        align-items: center;
        justify-content: center;
        pointer-events: none;     /* Không cho click */
        user-select: none;        /* Không cho bôi đen */
        background-color: #f8f9fa; /* Bootstrap bg-light */
    }
    </style>
@endsection

@section('script')
    <script>
        // --- PRO FILTER LOGIC ---
        let currentStatus = 'all';
        const rooms = @json($rooms->keyBy('id'));
        console.log(rooms);

        const services = @json($services);
        let servicesState = [];

        function filterStatus(status) {
            currentStatus = status;
            filterRooms();
        }

        function filterRooms() {
            // 1. Lấy giá trị inputs
            const keyword = document.getElementById('searchInput').value.toLowerCase();
            // const type = document.getElementById('typeFilter').value;
            const floor = document.getElementById('floorInput').value;

            // 2. Lấy danh sách phòng
            const rooms = document.querySelectorAll('.room-item');
            // console.log(rooms);

            rooms.forEach(room => {
                // Lấy data attributes
                const rNum = room.getAttribute('data-room').toLowerCase();
                // const rType = room.getAttribute('data-type');
                const rStatus = room.getAttribute('data-status'); // available, occupied, dirty
                // const rFloor = room.getAttribute('data-floor');

                // Lấy text hiển thị (để tìm tên khách)
                const contentText = room.innerText.toLowerCase();
                console.log(contentText);

                // 3. Kiểm tra điều kiện
                const matchKeyword = rNum.includes(keyword) || contentText.includes(keyword);
                const matchFloor = rNum.startsWith(floor)
                // const matchType = (type === 'all') || (rType === type);
                // const matchFloor = (floor === 'all') || (rFloor === floor);

                let matchStatus = false;
                if (currentStatus === 'all') matchStatus = true;
                else if (currentStatus === rStatus) matchStatus = true;
                // Logic phụ cho trạng thái đặt trước (demo quy về occupied hoặc tạo status riêng)

                // 4. Ẩn/Hiện
                if (matchKeyword && matchFloor && matchStatus) {
                    room.parentElement.classList.remove("d-none"); // Fix lỗi layout grid bootstrap
                    room.classList.remove("d-none");
                } else {
                    room.classList.add("d-none");
                }
            });
        }


        function openBookingListModal(id) {
            fetch(`/rooms/${id}/checkin-list`)
                .then(res => res.json())
                .then(data => {
                    renderCheckinModal(data);
                    var myModal = new bootstrap.Modal(document.getElementById('listBookingModal'));
                    myModal.show();
                });
        }

        function renderCheckinModal(data) {
            const list = data.bookings;

            if (!list.length) {
                document.getElementById('checkinModalBody').innerHTML =
                    `<div class="alert alert-warning text-center py-3">
                <i class="fas fa-info-circle me-1"></i>Không có đơn đặt phòng phù hợp thời gian.
            </div>`;
                return;
            }

            let html = "";

            list.forEach(b => {
                html += `
            <div class="card mb-3 shadow-sm border-0">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-bold fs-6 text-dark">
                                <i class="fas fa-user me-1 text-primary"></i>${b.customer.name}
                            </div>

                            <div class="small text-muted mt-1">
                                <i class="fas fa-clock me-1"></i>
                                Check-in: <b>${b.check_in}</b>
                            </div>

                            <div class="small text-muted">
                                <i class="fas fa-sign-out-alt me-1"></i>
                                Check-out: <b>${b.check_out}</b>
                            </div>

                            <div class="small text-muted">
                                <i class="fas fa-money-bill-wave me-1"></i>
                                Hình thức: <b>${b.rent_type}</b>
                            </div>

                            <div class="small text-muted">
                                <i class="fas fa-money-bill-wave me-1"></i>
                                Tổng: <b>${Number(b.total_price).toLocaleString()}đ</b>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            
                                
                            <button class="btn btn-success btn-sm"
                                onclick="confirmCheckin(${b.id})">
                                <i class="fas fa-check me-1"></i>Nhận phòng
                            </button>
                            <button class="btn btn-danger btn-sm"
                                onclick="rejectCheckin(${b.id})">
                                <i class="fas fa-times me-1"></i>Hủy phòng
                            </button>
                            
                        </div>
                    </div>

                </div>
            </div>
            `;
            });

            document.getElementById('checkinModalBody').innerHTML = html;
        }



        // Tìm kiếm khách hàng (Check-in)
        async function simulateSearchGuest() {
            const input = document.getElementById('searchGuestInput').value.trim();
            const alertBox = document.getElementById('guestFoundAlert');
            const nameInput = document.getElementById('guestName');
            const phoneInput = document.getElementById('guestPhone');

            if (input.length < 3) {
                alert("Vui lòng nhập ít nhất 3 ký tự để tìm kiếm");
                alertBox.classList.add('d-none');
                return;
            }

            try {
                const response = await fetch(`{{ route('booking.search-customer') }}?q=${encodeURIComponent(input)}`);
                const customers = await response.json();

                if (customers && customers.length > 0) {
                    const customer = customers[0]; // Lấy khách đầu tiên
                    console.log(customer);

                    // Hiện thông báo tìm thấy
                    alertBox.classList.remove('d-none');
                    alertBox.querySelector('.fw-bold').innerHTML =
                        `${customer.name} <span class="badge bg-warning text-dark ms-1">${customer.rank}</span>`;
                    alertBox.querySelector('.small').textContent = `${customer.phone || ''}`;

                    // Tự động điền form
                    nameInput.value = customer.name || '';
                    phoneInput.value = customer.phone || '';
                    document.querySelector('input[name="citizen_id"]').value = customer.citizen_id || '';
                    document.querySelector('input[name="address"]').value = customer.address || '';
                    document.querySelector('input[name="customer_id"]').value = customer.id || '';
                    if (customer.nationality) {
                        document.querySelector('select[name="nationality"]').value = customer.nationality;
                    }
                    if (customer.gender) {
                        document.querySelector('select[name="gender"]').value = customer.gender;
                    }
                } else {
                    alertBox.classList.add('d-none');
                    // Không tìm thấy, để người dùng nhập thủ công
                }
            } catch (error) {
                console.error('Error searching customer:', error);
                alert('Có lỗi xảy ra khi tìm kiếm khách hàng');
            }
        }



        /* --------------------------XỬ LÝ SERVICE---------------------------- */
        let data = null; // Global variable để lưu room data hiện tại

        function openModalService(bookingId, roomNum) {
            // Tìm room data từ bookingId
            let roomData = null;
            Object.values(rooms).forEach(r => {
                if (r.active_booking && r.active_booking.id == bookingId) {
                    roomData = r;
                }
            });

            if (!roomData || !roomData.active_booking) {
                alert('Không tìm thấy dữ liệu booking!');
                return;
            }

            data = roomData;
            document.getElementById('serviceRoomTitle').innerText = roomData.room_number;

            // Khởi tạo servicesState từ booking_service hiện có
            if (data.active_booking.booking_service && data.active_booking.booking_service.length > 0) {
                servicesState = JSON.parse(JSON.stringify(data.active_booking.booking_service));
            } else {
                servicesState = [];
            }

            var myModal = new bootstrap.Modal(document.getElementById('addServiceModal'));
            myModal.show();

            renderCart();
        }

        function renderCart() {
            //thêm menu services
            const tbodyServices = document.getElementById('tbodyServices');
            const menu = document.getElementById('menuService');
            menu.innerHTML = '';
            services.forEach((it, idx) => {
                const row = `
                    <div class="col-md-4 col-sm-6">
                        <div class="card h-100 shadow-sm border-0 room-card"
                            onclick="addToCart('${it.name}', ${it.price}, ${it.id})">
                            <div class="card-body p-2 text-center">
                                <h6 class="card-title fs-6 fw-bold mb-1">${it.name}</h6>
                                <div class="text-success fw-bold">${Number(it.price).toLocaleString()} ₫</div>
                            </div>
                        </div>
                    </div>`;
                menu.innerHTML += row
            });

            //------------------danh sách service đã chọn------------
            tbodyServices.innerHTML = ''
            if (data && data.active_booking && data.active_booking.booking_service) {
                data.active_booking.booking_service.forEach((it, idx) => {
                    const tr =
                        `
                                        <tr data-id="${it.service.id}">
                                            <td>${it.service.name}</td>
                                            <td>
                                                <div class="input-group input-group-sm">                                
                                                    <input type="text" class="form-control text-center px-0 py-0 quantity_service"
                                                        value="${it.quantity}" style="height:24px">
                                                </div>
                                            </td>
                                            <td class="text-end fw-bold total_price" data-price="${it.service.price}">${Number(it.service.price * it.quantity).toLocaleString()}</td>
                                            <td class="text-end"><i class="fas fa-times text-danger cursor-pointer"></i>
                                            </td>
                                        </tr>
                `
                    tbodyServices.innerHTML += tr
                });
            }

            //tổng tiền dịch vụ
            const totalServicePrice = document.getElementById('totalServicePrice')
            let totalService = 0;
            let totalQty = 0;

            if (data && data.active_booking && data.active_booking.booking_service) {
                totalService = data.active_booking.booking_service.reduce((sum, item) => {
                    return sum + (Number(item.service.price) * Number(item.quantity));
                }, 0);

                totalQty = data.active_booking.booking_service.reduce((sum, item) => {
                    return sum + Number(item.quantity);
                }, 0);
            }
            // totalServicePrice.innerHTML = ''
            const html = `
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tổng số lượng:</span>
                            <b id="totalQty">${Number(totalQty).toLocaleString()}</b>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-bold fs-5">TỔNG CỘNG:</span>
                            <span id="totalService" class="fw-bold fs-4 text-danger">
                                ${Number(totalService).toLocaleString()}
                            </span>
                        </div>
                        <button onclick="submitServices()" class="btn btn-warning w-100 fw-bold">
                            <i class="fas fa-save"></i> CẬP NHẬT DỊCH VỤ
                        </button>
                    `;

            // Gán HTML vào DOM
            totalServicePrice.innerHTML = html;

            /* ------------------------xử lí cộng trừ service----------------- */
            document.getElementById('tbodyServices').addEventListener('click', function(e) {

                //nút xóa
                if (e.target.matches('.cursor-pointer')) {
                    const row = e.target.closest('tr');
                    const id = row.dataset.id; // lấy id từ <tr data-id="">

                    // Xóa khỏi DOM
                    row.remove();

                    // Xóa khỏi state
                    servicesState = servicesState.filter(x => x.service.id != id);
                    console.log(servicesState);

                    // Update UI
                    handleTotalServices();
                }
            })



            document.getElementById('tbodyServices').addEventListener('input', function(e) {
                if (!e.target.matches('.quantity_service')) return;

                const row = e.target.closest('tr');
                const id = row.dataset.id;
                let qty = Number(e.target.value);

                // Nếu người dùng xóa input -> chưa xoá ngay, chuyển về 1
                if (e.target.value == '') return;

                // Nếu qty <= 0 -> xoá luôn dịch vụ
                if (qty <= 0) {
                    row.remove();
                    servicesState = servicesState.filter(x => x.service.id != id);
                    handleTotalServices();
                    return;
                }
                const item = servicesState.find(x => x.service.id == id);
                if (item) {
                    item.quantity = qty;
                }
                console.log(servicesState);
                // Cập nhật totals
                handleTotalServices();
            });
            /* --------------------------------------------------------------- */


        }



        // SIMULATE: Thêm vào giỏ hàng (Chỉ alert demo)
        function addToCart(itemName, price, id) {
            const tbody = document.getElementById('tbodyServices');

            // Kiểm tra service đã tồn tại chưa
            let row = tbody.querySelector(`tr[data-id="${id}"]`);

            if (row) {
                // Nếu tồn tại -> tăng qty
                let input = row.querySelector('.quantity_service');
                input.value = Number(input.value) + 1;
                const item = servicesState.find(x => x.service.id == id);
                if (item) {
                    item.quantity = input.value;
                }
            } else {

                // Nếu chưa có -> thêm vào state
                if (!data || !data.active_booking) {
                    alert('Không tìm thấy dữ liệu booking!');
                    return;
                }

                servicesState.push({
                    service: {
                        id: id,
                        name: itemName,
                        price: price,
                    },
                    service_id: id,
                    quantity: 1,
                    booking_id: data.active_booking.id
                });
                console.log(servicesState);

                // Nếu chưa có -> thêm row mới
                const tr = `
            <tr data-id="${id}">
                <td>${itemName}</td>
                <td>
                    <div class="input-group input-group-sm">
                        
                        <input type="text" class="form-control text-center px-0 py-0 quantity_service"
                            value="1" style="height:24px">
                        
                    </div>
                </td>
                <td class="text-end fw-bold total_price" data-price="${price}">
                    ${Number(price).toLocaleString()}
                </td>
                <td class="text-end">
                    <i class="fas fa-times text-danger cursor-pointer"></i>
                </td>
            </tr>
        `;
                tbody.insertAdjacentHTML("beforeend", tr);
            }

            // Update UI totals
            handleTotalServices();
        }


        // Submit Services
        function submitServices() {
            if (!data || !data.active_booking) {
                alert('Không tìm thấy dữ liệu booking!');
                return;
            }

            // Chuẩn bị dữ liệu services để gửi lên server
            const servicesToSubmit = servicesState.map(item => ({
                service_id: item.service.id,
                quantity: item.quantity
            }));

            // Gửi dữ liệu lên server
            const form = document.getElementById('servicesForm');
            const servicesInput = document.getElementById('servicesInput');
            servicesInput.value = JSON.stringify(servicesToSubmit);

            form.action = `{{ url('booking-services/booking-service/update') }}/${data.active_booking.id}`;
            form.submit();
        }


        function handleTotalServices() {
            //lấy tổng số lượng dịch vụ
            let totalQty = Number(document.getElementById('totalQty').textContent)

            // Lấy các input số lượng
            const quantity_service = document.querySelectorAll('.quantity_service')

            let quantity_service_array = Array.from(quantity_service);
            let newTotal = quantity_service_array.reduce((acc, cur) => {
                return acc + Number(cur.value)
            }, 0)

            document.getElementById('totalQty').textContent = newTotal


            //lấy ra tổng tiền của từng dịch vụ
            let total_price = Array.from(document.querySelectorAll('.total_price'))
            // console.log(Number(total_price[0].textContent).toLocaleString());
            let rows = Array.from(document.querySelectorAll('tr'))

            rows.forEach(row => {
                let input = row.querySelector('.quantity_service')
                let priceEl = row.querySelector('.total_price')

                if (!input || !priceEl) return

                let quantity = Number(input.value)
                let price = Number(priceEl.dataset.price) // đơn giá
                let total = price * quantity // thành tiền

                priceEl.textContent = total.toLocaleString()
            })

            console.log(total_price[0].dataset.price);

            let newTotalService = total_price.reduce((acc, cur) => {
                return acc + Number(cur.textContent.replace(/,/g, ""))
            }, 0)

            document.getElementById('totalService').textContent = Number(newTotalService).toLocaleString()

        }

        /* --------------------------XỬ LÝ SERVICE---------------------------- */





        // -------------------------Check in logic---------------------------//
        function openCheckinModal(roomId, roomNum) {
            document.getElementById('modalRoomTitle').innerText = roomNum;
            document.getElementById('checkinRoomId').value = roomId;
            // Clear old data
            document.getElementById('guestName').value = '';
            document.getElementById('guestPhone').value = '';
            document.getElementById('guestFoundAlert').classList.add('d-none');

            //gán số lượng người tối đa
            document.getElementById('people_count').innerText = rooms[roomId].room_type.max_people

            // Reset giá phòng
            const priceInput = document.getElementById('roomListedPrice');
            if (priceInput) {
                const roomData = rooms[roomId];
                if (roomData && roomData.room_type) {
                    // Set giá mặc định theo loại phòng
                    priceInput.value = Number((roomData.room_type.daily_rate || 0)).toLocaleString();
                } else {
                    priceInput.value = '0';
                }
            }

            var myModal = new bootstrap.Modal(document.getElementById('checkinModal'));
            myModal.show();
        }
        // Tính toán giá phòng dựa trên check_out time trong check-in form
        function calculateRoomPrice() {
            const checkInInput = document.querySelector('input[name="check_in"]');
            const checkOutInput = document.querySelector('input[name="check_out"]');
            const rentTypeInput = document.querySelector('input[name="rent_type"]:checked');
            const roomId = document.getElementById('checkinRoomId').value;


            // if (!checkInInput || !checkOutInput || !rentTypeInput || !roomId) return;
            if (!checkInInput.value || !checkOutInput.value || !rentTypeInput || !roomId) return;


            const checkIn = new Date(checkInInput.value);
            const checkOut = new Date(checkOutInput.value);
            const rentType = rentTypeInput.value;

            if (!checkIn || !checkOut || checkOut <= checkIn) return;

            // Lấy thông tin phòng từ rooms object
            const roomData = rooms[roomId];
            if (!roomData || !roomData.room_type) return;

            const roomType = roomData.room_type;
            let price = 0;
            let unit = '';

            console.log(roomType);
            console.log(roomType.daily_rate, roomType.initial_hour_rate, roomType.overnight_rate);

            if (rentType === 'hourly') {
                const hours = Math.ceil((checkOut - checkIn) / (1000 * 60 * 60));
                price = roomType.initial_hour_rate * hours;
                unit = 'giờ';
            } else if (rentType === 'overnight') {
                price = Number(roomType.overnight_rate).toLocaleString();
                unit = 'đêm';
            } else {
                const days = Math.ceil((checkOut - checkIn) / (1000 * 60 * 60 * 24));
                price = roomType.daily_rate * days;
                unit = 'ngày';
            }

            // Cập nhật giá phòng niêm yết trong form
            const priceInput = document.getElementById('roomListedPrice');
            if (priceInput) {
                priceInput.value = price.toLocaleString('vi-VN');
            }

        }

        // Gắn event listener cho check_out và rent_type khi modal mở
        document.addEventListener('DOMContentLoaded', function() {
            const checkinModal = document.getElementById('checkinModal');
            if (checkinModal) {
                checkinModal.addEventListener('shown.bs.modal', function() {
                    const checkOutInput = document.querySelector('#checkinModal input[name="check_out"]');
                    const rentTypeInputs = document.querySelectorAll(
                        '#checkinModal input[name="rent_type"]');

                    if (checkOutInput) {
                        checkOutInput.addEventListener('change', calculateRoomPrice);
                    }

                    rentTypeInputs.forEach(input => {
                        input.addEventListener('change', calculateRoomPrice);
                    });
                });
            }
        });

        /* --------------------------------------------------------------- */


        // --- CHECK-OUT LOGIC ---
        function openCheckoutModal(bookingId, roomNum) {
            if (!bookingId) return;

            // Tìm booking data từ biến 'rooms' (Object JS)
            // Cần tìm phòng nào có active_booking.id == bookingId
            let roomData = null;
            Object.values(rooms).forEach(r => {
                if (r.active_booking && r.active_booking.id == bookingId) {
                    roomData = r;
                }
            });

            if (!roomData) {
                alert("Không tìm thấy dữ liệu booking!");
                return;
            }

            const bk = roomData.active_booking;
            const customer = bk.customer || {
                name: 'Khách lẻ',
                phone: ''
            };

            // Update Form Action
            document.getElementById('checkoutForm').action = `/booking/check-out/${bk.id}`;
            document.getElementById('coRoomInfo').innerText = `P.${roomData.room_number}`;
            document.getElementById('coCustomerName').innerText = customer.name;
            document.getElementById('coCustomerPhone').innerText = customer.phone || '---';

            // Dates
            const now = new Date();
            document.getElementById('invoiceDate').innerText = now.toLocaleString('vi-VN');
            const inTime = new Date(bk.check_in);
            const outTime = new Date(bk.check_out)
            const realTime = new Date();
            document.getElementById('coCheckInTime').innerText = `Check-in: ${inTime.toLocaleString('vi-VN')}`;
            document.getElementById('coCheckOutTime').innerText = `Check-out: ${outTime.toLocaleString('vi-VN')}`;
            document.getElementById('realTime').innerText = `Giờ thực tế: ${realTime.toLocaleString('vi-VN')}`;

            // Calculate Duration & Price based on Rent Type
            const diffTime = Math.abs(now - inTime);
            const rentType = bk.rent_type || 'daily';
            const roomType = roomData.room_type || {};

            let quantity = 1;
            let unitName = 'ngày';
            let unitPrice = 0;
            let roomTotal = 0;

            if (rentType === 'hourly') {
                quantity = Math.ceil(diffTime / (1000 * 60 * 60));
                if (quantity < 1) quantity = 1;
                unitName = 'giờ';
                unitPrice = Number(roomType.initial_hour_rate || 0);
            } else if (rentType === 'overnight') {
                quantity = 1;
                unitName = 'đêm';
                unitPrice = Number(roomType.overnight_rate || 0);
            } else {
                // daily
                quantity = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                if (quantity < 1) quantity = 1;
                unitName = 'ngày';
                unitPrice = Number(roomType.daily_rate || 0);
            }

            roomTotal = quantity * unitPrice;


            // Services Total
            let serviceTotal = 0;
            let serviceRows = '';

            if (bk.booking_service && bk.booking_service.length > 0) {
                bk.booking_service.forEach((bs, index) => {
                    const lineTotal = bs.quantity * bs.service.price;
                    serviceTotal += lineTotal;
                    serviceRows += `
                        <tr>
                            <td>${index + 2}</td>
                            <td>${bs.service.name}</td>
                            <td class="text-center">${bs.quantity}</td>
                            <td class="text-end">${Number(bs.service.price).toLocaleString()}</td>
                            <td class="text-end">${Number(lineTotal).toLocaleString()}</td>
                        </tr>
                    `;
                });
            } else {
                serviceRows = `<tr><td colspan="5" class="text-center text-muted">Không sử dụng dịch vụ</td></tr>`;
            }

            // Build Invoice Table
            const roomRow = `
                <tr>
                    <td>1</td>
                    <td class="fw-bold">Tiền phòng (${quantity} ${unitName})</td>
                    <td class="text-center">${quantity}</td>
                    <td class="text-end">${Number(unitPrice).toLocaleString()}</td>
                    <td class="text-end fw-bold">${Number(roomTotal).toLocaleString()}</td>
                </tr>
            `;

            document.getElementById('coInvoiceBody').innerHTML = roomRow + serviceRows;

            // Summary Info
            const finalTotal = roomTotal + serviceTotal;
            document.getElementById('coRoomTotal').innerText = Number(roomTotal).toLocaleString() + ' ₫';
            document.getElementById('coServiceTotal').innerText = Number(serviceTotal).toLocaleString() + ' ₫';
            document.getElementById('coFinalTotal').innerText = Number(finalTotal).toLocaleString() + ' ₫';
            document.getElementById('coDisplayTotal').innerText = Number(finalTotal).toLocaleString() + ' ₫';

            var myModal = new bootstrap.Modal(document.getElementById('checkoutModal'));
            myModal.show();
        }

        /* ------------------------------------------------------------- */

        // --- MAINTENANCE LOGIC ---
        function submitMaintenance(roomId) {
            if (confirm('Xác nhận đưa phòng này vào bảo trì?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/booking/maintenance/${roomId}`;

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken;
                form.appendChild(csrfInput);

                document.body.appendChild(form);
                form.submit();
            }
        }

        // ----Kết thúc bảo trì?
        function finishMaintenance(roomId) {
            if (confirm('Xác nhận hoàn tất bảo trì?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/booking/maintenance/finish/${roomId}`;

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken;
                form.appendChild(csrfInput);

                document.body.appendChild(form);
                form.submit();
            }
        }

        // Kết thúc dọn dẹp
        function finishCleaning(roomId) {
            if (confirm('Xác nhận hoàn tất dọn dẹp?')) {
                const form = document.getElementById('finishCleaningForm');
                form.action = `/booking/cleaning/finish/${roomId}`;

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const csrfInput = document.createElement('input');

                document.body.appendChild(form);
                form.submit();
            }
        }

        function submitInvoice() {
            // Logic moved to form submit
        }
    </script>
@endsection
