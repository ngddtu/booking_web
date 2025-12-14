@extends('components.layout')

@section('title', 'Quản lý khách hàng')

@section('content')
    <!-- VIEW: CUSTOMERS MANAGEMENT -->
    <!-- 1. Thống kê nhanh (Mini status) -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm border-start border-4 border-primary">
                <div class="card-body py-3">
                    <small class="text-muted fw-bold text-uppercase">Tổng khách hàng</small>
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="fw-bold mb-0">{{ number_format($status['total']) }}</h4>
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
                        <h4 class="fw-bold mb-0 text-warning">{{ number_format($status['vip']) }}</h4>
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
                        <h4 class="fw-bold mb-0 text-danger">{{ number_format($status['blacklist']) }}</h4>
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
                        <form action="{{ route('customer.manage-customer') }}" method="post" class="w-100">
                            @csrf
                            <div class="input-group">
                                <button type="submit" class="btn btn-light"><span
                                        class="input-group-text bg-white border-end-0"><i
                                            class="fas fa-search text-secondary"></i></span></button>
                                <input type="text" id="searchCustomerInput" class="form-control border-start-0"
                                    placeholder="Tìm theo Tên, SĐT, CCCD..." name="phone" value="{{ request('phone') }}">
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Nút thêm -->
                <div class="col-md-4 text-md-end text-start">
                    <button class="btn btn-primary btn-sm" onclick="openCreateModal()">
                        <i class="fas fa-user-plus"></i> Thêm khách mới
                    </button>
                    <!-- <button class="btn btn-outline-secondary btn-sm" title="Xuất Excel"><i
                                class="fas fa-file-export"></i></button> -->
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
                        @forelse($customers as $customer)
                            <tr class="@if ($customer->rank == 'blacklist') table-danger @endif">
                                <td class="ps-3">
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($customer->name) }}&background=random"
                                            class="rounded-circle me-2" width="40">
                                        <div>
                                            <div
                                                class="fw-bold @if ($customer->rank == 'blacklist') text-danger @else text-dark @endif">
                                                {{ $customer->name }}</div>
                                            <small class="text-muted"><i class="fas fa-map-marker-alt"></i>
                                                {{ $customer->address ?? 'N/A' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $customer->phone }}</div>
                                    <small class="text-secondary"><i class="far fa-id-card"></i>
                                        {{ $customer->citizen_id ?? '--' }}</small>
                                </td>
                                <td>
                                    @if ($customer->rank == 'vip')
                                        <span class="badge bg-warning text-dark"><i class="fas fa-crown"></i> VIP</span>
                                    @elseif($customer->rank == 'blacklist')
                                        <span class="badge bg-dark">Blacklist</span>
                                    @else
                                        <span class="badge bg-secondary">Khách lẻ</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="small">Đã ở: <b>{{ $customer->bookings_count }} lần</b></div>
                                    <small class="text-muted">Chi tiêu:
                                        {{ number_format($customer->bookings_sum_total_price) }}</small>
                                </td>
                                <td>
                                    @if ($customer->status == 'active')
                                        <span class="badge bg-success bg-opacity-10 text-success">Hoạt động</span>
                                    @else
                                        <span class="badge bg-danger">Đang khóa</span>
                                    @endif
                                </td>
                                <td class="text-end pe-3">
                                    <button class="btn btn-sm btn-light border"
                                        onclick="openEditModal({{ $customer->id }})"><i
                                            class="fas fa-edit text-primary"></i></button>
                                    <!-- Form delete -->
                                    <form action="{{ route('customer.destroy', $customer->id) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa khách hàng này?')">
                                        <!-- Note: route destroy might need update if not defined properly, using basic convention but user routes prefix is customer. -->
                                        <!-- Actually route name from `web.php` for customer is not fully defined with resource? -->
                                        <!-- Wait, checking web.php, only `index` is defined for `manage-customer`. I need to add routes! -->
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">Chưa có dữ liệu khách hàng</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Phân trang -->
        <div class="card-footer bg-white py-2">
            {{ $customers->links() }}
        </div>
    </div>


    <!-- Modal: QUẢN LÝ KHÁCH HÀNG (CRUD) -->
    <div class="modal fade" id="customerModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="customerForm" method="POST">
                    @csrf
                    <div id="methodField"></div>
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalTitle"><i class="fas fa-user-circle"></i> Thông tin Khách hàng
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <!-- Hàng 1 -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" id="cName"
                                    placeholder="Nhập tên khách..." required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Số điện thoại <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="phone" id="cPhone"
                                    placeholder="09xxxxxxx" required>
                            </div>

                            <!-- Hàng 2 -->
                            <div class="col-md-6">
                                <label class="form-label">CCCD / CMND / Hộ chiếu</label>
                                <input type="text" class="form-control" name="citizen_id" id="cCitizenId"
                                    placeholder="Số giấy tờ tùy thân">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="cEmail"
                                    placeholder="khachhang@example.com">
                            </div>

                            <!-- Hàng 3 -->
                            <div class="col-md-4">
                                <label class="form-label">Ngày sinh</label>
                                <input type="date" class="form-control" name="birthday" id="cBirthday">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Quốc tịch</label>
                                <select class="form-select" name="nationality" id="cNationality">
                                    <option value="Việt Nam" selected>Việt Nam</option>
                                    <option value="Hàn Quốc">Hàn Quốc</option>
                                    <option value="Trung Quốc">Trung Quốc</option>
                                    <option value="Khác">Khác...</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Nhóm khách</label>
                                <select class="form-select" name="rank" id="cRank">
                                    <option value="normal">Khách lẻ (Thường)</option>
                                    <option value="vip">VIP (Thân thiết)</option>
                                    <option value="blacklist" class="text-danger fw-bold">Blacklist (Chặn)</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Trạng thái</label>
                                <select class="form-select" name="status" id="cStatus">
                                    <option value="active" class="text-success">Hoạt động</option>
                                    <option value="locked" class="text-danger">Đang khóa</option>
                                </select>
                            </div>

                            <!-- Hàng 4 -->
                            <div class="col-md-12">
                                <label class="form-label">Giới tính</label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="genderMale"
                                            value="male">
                                        <label class="form-check-label" for="genderMale">Nam</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="genderFemale"
                                            value="female">
                                        <label class="form-check-label" for="genderFemale">Nữ</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="genderOther"
                                            value="other">
                                        <label class="form-check-label" for="genderOther">Khác</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Hàng 5 -->
                            <div class="col-12">
                                <label class="form-label">Địa chỉ</label>
                                <input type="text" class="form-control" name="address" id="cAddress"
                                    placeholder="Số nhà, đường, phường/xã...">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Ghi chú nội bộ</label>
                                <textarea class="form-control" rows="3" name="note" id="cNote"
                                    placeholder="VD: Khách thích phòng yên tĩnh, dị ứng hải sản..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Lưu hồ sơ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        const modalEl = document.getElementById('customerModal');
        const modal = new bootstrap.Modal(modalEl);
        const form = document.getElementById('customerForm');
        const modalTitle = document.getElementById('modalTitle');
        const methodField = document.getElementById('methodField');

        function openCreateModal() {
            form.reset();
            methodField.innerHTML = ''; // POST
            form.action = "{{ route('customer.store') }}"; // Need to define this route!
            modalTitle.innerHTML = '<i class="fas fa-user-plus"></i> Thêm khách mới';
            modal.show();
        }

        function openEditModal(id) {
            // Fetch data
            fetch(`/customer/show/${id}`) // Need to define this route!
                .then(response => response.json())
                .then(data => {
                    document.getElementById('cName').value = data.name;
                    document.getElementById('cPhone').value = data.phone;
                    document.getElementById('cEmail').value = data.email || '';
                    document.getElementById('cCitizenId').value = data.citizen_id || '';
                    document.getElementById('cBirthday').value = data.birthday || '';
                    document.getElementById('cNationality').value = data.nationality || 'Việt Nam';
                    document.getElementById('cRank').value = data.rank || 'normal';
                    document.getElementById('cStatus').value = data.status || 'active';
                    document.getElementById('cAddress').value = data.address || '';
                    document.getElementById('cNote').value = data.note || '';

                    if (data.gender === 'male') document.getElementById('genderMale').checked = true;
                    else if (data.gender === 'female') document.getElementById('genderFemale').checked = true;
                    else if (data.gender === 'other') document.getElementById('genderOther').checked = true;

                    methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
                    form.action = `/customer/update/${id}`; // Need to define this route!
                    modalTitle.innerHTML = '<i class="fas fa-user-edit"></i> Cập nhật khách hàng';
                    modal.show();
                });
        }
    </script>
@endsection
