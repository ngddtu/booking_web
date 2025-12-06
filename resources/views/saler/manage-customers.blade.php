@extends('components.layout')

@section('title', 'Quản lý khách hàng')

@section('content')
    <!-- VIEW: CUSTOMERS MANAGEMENT -->
    <!-- 1. Thống kê nhanh (Mini Stats) -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm border-start border-4 border-primary">
                <div class="card-body py-3">
                    <small class="text-muted fw-bold text-uppercase">Tổng khách hàng</small>
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="fw-bold mb-0">1,250</h4>
                        <i class="fas fa-users fa-2x text-primary opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm border-start border-4 border-warning">
                <div class="card-body py-3">
                    <small class="text-muted fw-bold text-uppercase">Khách VIP</small>
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="fw-bold mb-0 text-warning">45</h4>
                        <i class="fas fa-crown fa-2x text-warning opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm border-start border-4 border-dark">
                <div class="card-body py-3">
                    <small class="text-muted fw-bold text-uppercase">Blacklist (Chặn)</small>
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="fw-bold mb-0 text-danger">3</h4>
                        <i class="fas fa-ban fa-2x text-dark opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Bảng dữ liệu khách hàng -->
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-address-book text-primary"></i> Hồ sơ khách hàng
                    </h5>
                </div>
                <!-- Ô tìm kiếm -->
                <div class="col-md-4 my-2 my-md-0">
                    <div class="input-group input-group-sm">
                        <form action="{{ route('customer.manage-customer') }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-light"><span
                                    class="input-group-text bg-white border-end-0"><i
                                        class="fas fa-search text-secondary"></i></span></button>
                            <input type="text" id="searchCustomerInput" class="form-control border-start-0"
                                placeholder="Tìm theo Tên, SĐT, CCCD..." name="phone">
                        </form>
                    </div>
                </div>
                <!-- Nút thêm -->
                <div class="col-md-4 text-md-end text-start">
                    <button class="btn btn-primary btn-sm" onclick="openModal('customerModal')">
                        <i class="fas fa-user-plus"></i> Thêm khách mới
                    </button>
                    <button class="btn btn-outline-secondary btn-sm" title="Xuất Excel"><i
                            class="fas fa-file-export"></i></button>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="customerTable">
                    <thead class="bg-light text-secondary">
                        <tr>
                            <th class="ps-3">Thông tin khách hàng</th>
                            <th>Liên hệ / CCCD</th>
                            <th>Nhóm khách</th>
                            <th>Lịch sử</th>
                            <th>Trạng thái</th>
                            <th class="text-end pe-3">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Khách 1: VIP -->
                        <tr>
                            <td class="ps-3">
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name=Nguyen+Van+A&background=random"
                                        class="rounded-circle me-2" width="40">
                                    <div>
                                        <div class="fw-bold text-dark">Nguyễn Văn A</div>
                                        <small class="text-muted"><i class="fas fa-map-marker-alt"></i> Hà Nội</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold">0909.123.456</div>
                                <small class="text-secondary"><i class="far fa-id-card"></i> 001098000xxx</small>
                            </td>
                            <td><span class="badge bg-warning text-dark"><i class="fas fa-crown"></i> VIP Gold</span>
                            </td>
                            <td>
                                <div class="small">Đã ở: <b>12 lần</b></div>
                                <small class="text-muted">Chi tiêu: 15.5tr</small>
                            </td>
                            <td><span class="badge bg-success bg-opacity-10 text-success">Hoạt động</span></td>
                            <td class="text-end pe-3">
                                <button class="btn btn-sm btn-light border"><i
                                        class="fas fa-edit text-primary"></i></button>
                                <button class="btn btn-sm btn-light border"><i
                                        class="fas fa-history text-info"></i></button>
                            </td>
                        </tr>

                        <!-- Khách 2: Thường -->
                        <tr>
                            <td class="ps-3">
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name=Tran+Thi+B&background=random"
                                        class="rounded-circle me-2" width="40">
                                    <div>
                                        <div class="fw-bold text-dark">Trần Thị B</div>
                                        <small class="text-muted"><i class="fas fa-map-marker-alt"></i> TP.HCM</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold">0912.888.999</div>
                                <small class="text-secondary"><i class="far fa-id-card"></i> 079190000xxx</small>
                            </td>
                            <td><span class="badge bg-secondary">Khách lẻ</span></td>
                            <td>
                                <div class="small">Đã ở: <b>1 lần</b></div>
                                <small class="text-muted">Chi tiêu: 500k</small>
                            </td>
                            <td><span class="badge bg-success bg-opacity-10 text-success">Hoạt động</span></td>
                            <td class="text-end pe-3">
                                <button class="btn btn-sm btn-light border"><i
                                        class="fas fa-edit text-primary"></i></button>
                                <button class="btn btn-sm btn-light border"><i
                                        class="fas fa-history text-info"></i></button>
                            </td>
                        </tr>

                        <!-- Khách 3: Blacklist -->
                        <tr class="table-danger">
                            <td class="ps-3">
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name=Le+Van+Xau&background=000&color=fff"
                                        class="rounded-circle me-2" width="40">
                                    <div>
                                        <div class="fw-bold text-danger">Lê Văn Xấu</div>
                                        <small class="text-muted"><i class="fas fa-map-marker-alt"></i> Hải
                                            Phòng</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold">0988.666.666</div>
                                <small class="text-secondary"><i class="far fa-id-card"></i> 031090000xxx</small>
                            </td>
                            <td><span class="badge bg-dark">Blacklist</span></td>
                            <td>
                                <div class="small">Đã ở: <b>2 lần</b></div>
                                <small class="text-danger fw-bold">Làm hỏng TV</small>
                            </td>
                            <td><span class="badge bg-danger">Đang chặn</span></td>
                            <td class="text-end pe-3">
                                <button onclick="openModalService()" class="btn btn-sm btn-light border"><i
                                        class="fas fa-edit text-primary"></i></button>
                                <button class="btn btn-sm btn-light border"><i
                                        class="fas fa-unlock text-success"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Phân trang -->
        <div class="card-footer bg-white py-2">
            <nav>
                <ul class="pagination justify-content-end mb-0 pagination-sm">
                    <li class="page-item disabled"><a class="page-link" href="#">Trước</a></li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">Sau</a></li>
                </ul>
            </nav>
        </div>
    </div>


    <!-- Modal: QUẢN LÝ KHÁCH HÀNG (CRUD) -->
    <div class="modal fade" id="customerModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-user-circle"></i> Thông tin Khách hàng</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row g-3">
                            <!-- Hàng 1 -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Nhập tên khách...">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Số điện thoại <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="09xxxxxxx">
                            </div>

                            <!-- Hàng 2 -->
                            <div class="col-md-6">
                                <label class="form-label">CCCD / CMND / Hộ chiếu</label>
                                <input type="text" class="form-control" placeholder="Số giấy tờ tùy thân">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" placeholder="khachhang@example.com">
                            </div>

                            <!-- Hàng 3 -->
                            <div class="col-md-4">
                                <label class="form-label">Ngày sinh</label>
                                <input type="date" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Quốc tịch</label>
                                <select class="form-select">
                                    <option selected>Việt Nam</option>
                                    <option>Hàn Quốc</option>
                                    <option>Trung Quốc</option>
                                    <option>Khác...</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Nhóm khách</label>
                                <select class="form-select">
                                    <option value="normal">Khách lẻ (Thường)</option>
                                    <option value="vip">VIP (Thân thiết)</option>
                                    <option value="blacklist" class="text-danger fw-bold">Blacklist (Chặn)</option>
                                </select>
                            </div>

                            <!-- Hàng 4 -->
                            <div class="col-12">
                                <label class="form-label">Địa chỉ</label>
                                <input type="text" class="form-control" placeholder="Số nhà, đường, phường/xã...">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Ghi chú nội bộ</label>
                                <textarea class="form-control" rows="3" placeholder="VD: Khách thích phòng yên tĩnh, dị ứng hải sản..."></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary"><i class="fas fa-save"></i> Lưu hồ sơ</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function openModalService() {




            const modal = new bootstrap.Modal(document.getElementById('customerModal'));
            modal.show();
        }
    </script>
@endsection
