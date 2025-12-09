@extends('components.layout')

@section('title', 'Sơ đồ phòng')

@section('content')
    <!-- VIEW 2: PROFESSIONAL ROOM PLAN -->
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
                            <h4 class="mb-0 fw-bold text-dark">10 <span class="text-muted fs-6 font-weight-normal">/
                                    20</span></h4>
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
                            <h4 class="mb-0 fw-bold text-dark">8</h4>
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
                            <h4 class="mb-0 fw-bold text-dark">1</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
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
            </div>
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
                    <div class="col-lg-2 col-md-3">
                        <select id="typeFilter" class="form-select form-select-sm" onchange="filterRooms()">
                            <option value="all">-- Tất cả loại --</option>
                            <option value="Đơn">Phòng Đơn</option>
                            <option value="Đôi">Phòng Đôi</option>
                            <option value="VIP">Phòng VIP</option>
                        </select>
                    </div>

                    <!-- Bộ lọc Tầng -->
                    <div class="col-lg-2 col-md-3">
                        <select id="floorFilter" class="form-select form-select-sm" onchange="filterRooms()">
                            <option value="all">-- Tất cả tầng --</option>
                            <option value="1">Tầng 1</option>
                            <option value="2">Tầng 2</option>
                            <option value="3">Tầng 3</option>
                        </select>
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
                <gitroom-card :room="$room" />
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
                                        <input type="text" id="searchGuestInput" class="form-control"
                                            placeholder="Nhập số điện thoại...">
                                        <button class="btn btn-primary" type="button" onclick="simulateSearchGuest()">
                                            <i class="fas fa-search"></i> Tìm
                                        </button>
                                    </div>

                                    <!-- Khu vực hiển thị kết quả tìm kiếm (Mặc định ẩn) -->
                                    <div id="guestFoundAlert" class="alert alert-info d-flex align-items-center d-none"
                                        role="alert">
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
                                                id="guestName" placeholder="VD: Tran Van B">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small text-muted">Giới tính</label>
                                            <select class="form-select form-select-sm">
                                                <option>Nam</option>
                                                <option>Nữ</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small text-muted">Số CCCD/Hộ chiếu</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small text-muted">Quốc tịch</label>
                                            <select class="form-select form-select-sm">
                                                <option>Việt Nam</option>
                                                <option>Quốc tế...</option>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label small text-muted">Địa chỉ (Tùy chọn)</label>
                                            <input type="text" class="form-control form-control-sm"
                                                placeholder="Ghi chú địa chỉ...">
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
                                                <input type="radio" class="btn-check" name="rentType" id="typeHour"
                                                    autocomplete="off" checked>
                                                <label class="btn btn-outline-secondary btn-sm" for="typeHour">Theo
                                                    giờ</label>

                                                <input type="radio" class="btn-check" name="rentType" id="typeNight"
                                                    autocomplete="off">
                                                <label class="btn btn-outline-secondary btn-sm" for="typeNight">Qua
                                                    đêm</label>

                                                <input type="radio" class="btn-check" name="rentType" id="typeDay"
                                                    autocomplete="off">
                                                <label class="btn btn-outline-secondary btn-sm" for="typeDay">Theo
                                                    ngày</label>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-bold small">Số người</label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text"><i class="fas fa-users"></i></span>
                                                <input type="number" class="form-control text-center" value="2">
                                                <span class="input-group-text">Người</span>
                                            </div>
                                        </div>

                                        <!-- Thời gian -->
                                        <div class="col-md-6">
                                            <label class="form-label small text-muted">Thời gian vào (Check-in)</label>
                                            <input type="datetime-local" class="form-control form-control-sm"
                                                value="2023-11-27T14:30">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small text-muted">Dự kiến ra (Check-out)</label>
                                            <input type="datetime-local" class="form-control form-control-sm bg-light"
                                                readonly value="2023-11-27T16:30">
                                        </div>

                                        <!-- Tài chính -->
                                        <div class="col-12 mt-4">
                                            <div class="bg-light p-3 rounded border border-success border-opacity-25">
                                                <div class="row align-items-end">
                                                    <div class="col-md-4">
                                                        <label class="form-label small fw-bold">Giá phòng niêm yết</label>
                                                        <div class="input-group input-group-sm">
                                                            <input type="text" class="form-control fw-bold text-dark"
                                                                value="150,000">
                                                            <span class="input-group-text">₫</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label small fw-bold text-primary">Tiền trả trước
                                                            / Cọc</label>
                                                        <div class="input-group input-group-sm">
                                                            <input type="text"
                                                                class="form-control fw-bold text-primary" placeholder="0">
                                                            <span class="input-group-text">₫</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label small fw-bold">Phương thức</label>
                                                        <select class="form-select form-select-sm">
                                                            <option>Tiền mặt</option>
                                                            <option>Chuyển khoản</option>
                                                            <option>Thẻ</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label small text-muted">Ghi chú (Yêu cầu đặc biệt)</label>
                                            <textarea class="form-control form-control-sm" rows="2" placeholder="VD: Khách cần mượn bàn ủi..."></textarea>
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
                        <button type="button" class="btn btn-success fw-bold px-4"><i class="fas fa-check"></i> XÁC NHẬN
                            NHẬN PHÒNG</button>
                    </div>
                </div>
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

                <div class="modal-body bg-light">
                    <div class="row h-100">

                        <!-- PHẦN 1: PREVIEW HÓA ĐƠN (LEFT SIDE) -->
                        <div class="col-lg-8 mb-3 mb-lg-0">
                            <div class="card shadow-sm border-0 h-100 receipt-paper">
                                <div class="card-body p-4 position-relative">
                                    <!-- Watermark (Optional) -->
                                    {{-- <i class="fas fa-hotel position-absolute top-50 start-50 translate-middle text-secondary opacity-10"
                                        style="font-size: 10rem;"></i> --}}

                                    <!-- Invoice Header -->
                                    <div class="d-flex justify-content-between mb-4 border-bottom pb-3">
                                        <div>
                                            <h4 class="fw-bold text-uppercase text-primary mb-1">PMS HOTEL</h4>
                                            <small class="text-muted">123 Đường ABC, Quận 1, TP.HCM</small><br>
                                            <small class="text-muted">Hotline: 1900 1000</small>
                                        </div>
                                        <div class="text-end">
                                            <h5 class="fw-bold">HÓA ĐƠN GTGT</h5>
                                            <div class="text-muted small">Mã HĐ: <span
                                                    class="fw-bold text-dark">#INV-20231127-001</span></div>
                                            <div class="text-muted small">Ngày lập: <span id="invoiceDate">27/11/2023
                                                    12:00</span></div> <!-- issued_at -->
                                        </div>
                                    </div>

                                    <!-- Guest & Booking Info (Mapping user_id & booking_id) -->
                                    <div class="row mb-4 small">
                                        <div class="col-6">
                                            <label class="text-muted fw-bold">Khách hàng (User):</label>
                                            <div class="fw-bold fs-6">Nguyễn Văn Khách</div>
                                            <div>SĐT: 0909.888.xxx</div>
                                        </div>
                                        <div class="col-6 text-end">
                                            <label class="text-muted fw-bold">Thông tin phòng:</label>
                                            <div class="fw-bold fs-6 badge bg-primary">P.102 - Deluxe</div>
                                            <div>Check-in: 25/11/2023 14:00</div>
                                            <div>Check-out: 27/11/2023 12:00</div>
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
                                            <tbody>
                                                <!-- Tiền phòng -->
                                                <tr>
                                                    <td>1</td>
                                                    <td class="fw-bold">Tiền phòng (2 Đêm)</td>
                                                    <td class="text-center">2</td>
                                                    <td class="text-end">400,000</td>
                                                    <td class="text-end fw-bold">800,000</td>
                                                </tr>
                                                <!-- Dịch vụ -->
                                                <tr>
                                                    <td>2</td>
                                                    <td>Nước suối</td>
                                                    <td class="text-center">4</td>
                                                    <td class="text-end">10,000</td>
                                                    <td class="text-end">40,000</td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Giặt ủi</td>
                                                    <td class="text-center">2 kg</td>
                                                    <td class="text-end">50,000</td>
                                                    <td class="text-end">100,000</td>
                                                </tr>
                                                <!-- Phụ thu -->
                                                <tr class="text-danger">
                                                    <td>4</td>
                                                    <td>Phụ thu (Late Check-out 1h)</td>
                                                    <td class="text-center">1</td>
                                                    <td class="text-end">50,000</td>
                                                    <td class="text-end">50,000</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Tổng kết số tiền -->
                                    <div class="row justify-content-end">
                                        <div class="col-md-6">
                                            <table class="table table-borderless table-sm text-end">
                                                <tr>
                                                    <td class="text-muted">Tổng tạm tính:</td>
                                                    <td class="fw-bold">990,000 ₫</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted">Giảm giá (Voucher):</td>
                                                    <td class="text-success">- 0 ₫</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted">Đã cọc trước:</td>
                                                    <td class="text-primary fw-bold">- 200,000 ₫</td>
                                                </tr>
                                                <tr class="border-top border-2 border-dark">
                                                    <td class="pt-2 fs-5 fw-bold">CẦN THANH TOÁN (Total):</td>
                                                    <td class="pt-2 fs-4 fw-bold text-danger">790,000 ₫</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- PHẦN 2: THANH TOÁN & ACTION (RIGHT SIDE) -->
                        <div class="col-lg-4">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-header bg-primary text-white text-center py-3">
                                    <span class="small opacity-75 text-uppercase">Tổng tiền phải thu</span>
                                    <h2 class="fw-bold m-0">790,000 ₫</h2> <!-- Mapping field: total -->
                                </div>
                                <div class="card-body d-flex flex-column">

                                    <!-- Chọn phương thức thanh toán (Mapping payment_id) -->
                                    <div class="mb-4">
                                        <label class="form-label fw-bold small text-muted text-uppercase mb-2">Phương thức
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

                                            <input type="radio" class="btn-check" name="payment_id" id="pay_transfer"
                                                value="2">
                                            <label
                                                class="btn btn-outline-secondary text-start d-flex justify-content-between align-items-center"
                                                for="pay_transfer">
                                                <span><i class="fas fa-university me-2 text-primary"></i> Chuyển khoản
                                                    (QR)</span>
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

                                    <!-- Các tùy chọn khác -->
                                    <div class="mb-3">
                                        <label class="form-label small text-muted">Ghi chú hóa đơn</label>
                                        <textarea class="form-control" rows="2" placeholder="VD: Khách quên sạc, đã gửi lại lễ tân..."></textarea>
                                    </div>

                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="printBillCheck" checked>
                                        <label class="form-check-label small" for="printBillCheck">In hóa đơn ngay sau khi
                                            lưu</label>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="mt-auto gap-2 d-grid">
                                        <button class="btn btn-success btn-lg fw-bold shadow-sm">
                                            <i class="fas fa-check-double"></i> HOÀN TẤT & TRẢ PHÒNG
                                        </button>
                                        <button class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                            Quay lại
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>



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
    </style>
@endsection

@section('script')
    <script>
        // --- PRO FILTER LOGIC ---
        let currentStatus = 'all';
        const rooms = @json($rooms->keyBy('id'));
        const services = @json($services);
        let servicesState = [];

        function filterStatus(status) {
            currentStatus = status;
            filterRooms();
        }

        function filterRooms() {
            // 1. Lấy giá trị inputs
            const keyword = document.getElementById('searchInput').value.toLowerCase();
            const type = document.getElementById('typeFilter').value;
            const floor = document.getElementById('floorFilter').value;

            // 2. Lấy danh sách phòng
            const rooms = document.querySelectorAll('.room-item');

            rooms.forEach(room => {
                // Lấy data attributes
                const rNum = room.getAttribute('data-room').toLowerCase();
                const rType = room.getAttribute('data-type');
                const rStatus = room.getAttribute('data-status'); // available, occupied, dirty
                const rFloor = room.getAttribute('data-floor');

                // Lấy text hiển thị (để tìm tên khách)
                const contentText = room.innerText.toLowerCase();

                // 3. Kiểm tra điều kiện
                const matchKeyword = rNum.includes(keyword) || contentText.includes(keyword);
                const matchType = (type === 'all') || (rType === type);
                const matchFloor = (floor === 'all') || (rFloor === floor);

                let matchStatus = false;
                if (currentStatus === 'all') matchStatus = true;
                else if (currentStatus === rStatus) matchStatus = true;
                // Logic phụ cho trạng thái đặt trước (demo quy về occupied hoặc tạo status riêng)

                // 4. Ẩn/Hiện
                if (matchKeyword && matchType && matchFloor && matchStatus) {
                    room.parentElement.style.display = 'block'; // Fix lỗi layout grid bootstrap
                    room.style.display = 'block';
                } else {
                    room.style.display = 'none';
                }
            });
        }


        // SIMULATE: Tìm kiếm khách hàng (Check-in)
        function simulateSearchGuest() {
            const input = document.getElementById('searchGuestInput').value;
            const alertBox = document.getElementById('guestFoundAlert');
            const nameInput = document.getElementById('guestName');

            // Giả lập: Nếu nhập gì đó thì tìm thấy
            if (input.length > 3) {
                // Hiện thông báo tìm thấy
                alertBox.classList.remove('d-none');
                // Tự động điền form
                nameInput.value = "Nguyễn Văn A";
            } else {
                alert("Vui lòng nhập SĐT khách hàng (ít nhất 4 số demo)");
                alertBox.classList.add('d-none');
                nameInput.value = "";
            }
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
            handleTotals();
        }

        // Cập nhật hàm mở modal để hỗ trợ modal dịch vụ mới
        // function openModal(modalId, roomNum) {
        //     if (modalId === 'checkinModal') {
        //         document.getElementById('modalRoomTitle').innerText = roomNum;
        //     } else if (modalId === 'addServiceModal') { // Modal mới
        //         document.getElementById('serviceRoomTitle').innerText = roomNum;
        //     } else if (modalId === 'checkoutModal') {
        //         document.getElementById('coRoomTitle').innerText = roomNum;
        //     }

        //     var myModal = new bootstrap.Modal(document.getElementById(modalId));
        //     myModal.show();
        // }



        /* --------------------------XỬ LÝ SERVICE---------------------------- */
        function openModalService(id) {
            data = rooms[id]
            // console.log(data['active_booking']['booking_service']);
            servicesState = JSON.parse(JSON.stringify(data.active_booking.booking_service));
            console.log(servicesState);

            var myModal = new bootstrap.Modal(document.getElementById('addServiceModal'));
            myModal.show()




            renderCart();
            // Lấy tổng qty hiện tại (số)

        }

        function handleTotals() {
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
            console.log(newTotalService * 1000);

            document.getElementById('totalService').textContent = Number(newTotalService * 1000).toLocaleString()

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
            data['active_booking']['booking_service'].forEach((it, idx) => {
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

            //tổng tiền dịch vụ
            const totalServicePrice = document.getElementById('totalServicePrice')
            const totalService = data.active_booking.booking_service.reduce((sum, item) => {
                return sum + (Number(item.service.price) * Number(item.quantity));
            }, 0);

            const totalQty = data.active_booking.booking_service.reduce((sum, item) => {
                return sum + Number(item.quantity);
            }, 0);
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
                //nút trừ
                // if (e.target.matches('.minus-btn')) {
                //     const id = e.target.dataset.set;
                //     const input = e.target.nextElementSibling;
                //     let qty = parseFloat(input.value);
                //     qty-- // trừ trước

                //     if (qty <= 0) {
                //         const row = e.target.closest('tr');
                //         row.remove();
                //         handleTotals();
                //         return; // thoát để không set input.value tiếp
                //     }

                //     input.value = qty
                //     handleTotals();
                // }

                // //nút cộng
                // if (e.target.matches('.plus-btn')) {
                //     const id = e.target.dataset.set;

                //     const input = e.target.previousElementSibling;
                //     let qty = parseFloat(input.value);
                //     if (qty >= 0) qty++

                //     input.value = qty
                //     handleTotals();
                // }

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
                    handleTotals();
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
                    handleTotals();
                    return;
                }
                const item = servicesState.find(x => x.service.id == id);
                if (item) {
                    item.quantity = qty;
                }
                console.log(servicesState);
                // Cập nhật totals
                handleTotals();
            });
            /* --------------------------------------------------------------- */


        }


        // Hàm mở Modal Check-out (Giả lập lấy dữ liệu từ DB)
        function openCheckoutModal(roomId) {
            // 1. Cập nhật ngày giờ xuất hóa đơn (Mapping field: issued_at)
            const now = new Date();
            const dateString = now.toLocaleString('vi-VN');
            document.getElementById('invoiceDate').innerText = dateString;

            // 2. Logic giả lập: Tính toán Total
            // Trong thực tế: Gọi API lấy booking_id, tính tổng service, trừ cọc...
            console.log("Đang mở checkout cho phòng: " + roomId);

            // 3. Hiển thị Modal
            var myModal = new bootstrap.Modal(document.getElementById('checkoutModal'));
            myModal.show();
        }

        function submitServices() {
            document.getElementById('servicesInput').value = JSON.stringify(servicesState);
            document.getElementById('servicesForm').action =
                `/booking-services/booking-service/update/${data.active_booking.id}`
            document.getElementById('servicesForm').submit();
        }


        // Logic khi bấm "Hoàn tất"
        function submitInvoice() {
            // Lấy dữ liệu để đẩy vào bảng invoices
            // const invoiceData = {
            //     user_id: 123, // ID khách hàng
            //     booking_id: 456, // ID booking hiện tại
            //     payment_id: document.querySelector('input[name="payment_id"]:checked').value,
            //     total: 790000, // Giá trị final
            //     issued_at: new Date().toISOString().slice(0, 19).replace('T', ' ')
            // };

            // console.log("Dữ liệu lưu vào DB:", invoiceData);
            // alert("Thanh toán thành công! Đang in hóa đơn...");
        }
    </script>
@endsection
