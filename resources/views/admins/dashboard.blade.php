@extends('components.layout')

@section('content')
    <div class="row g-3">
        <!-- Card Doanh thu -->
        <div class="col-md-3">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white-50">Doanh thu hôm nay</h6>
                            <h3 class="fw-bold">5.200.000 ₫</h3>
                        </div>
                        <i class="fas fa-dollar-sign fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card Khách -->
        <div class="col-md-3">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white-50">Công suất phòng</h6>
                            <h3 class="fw-bold">8 / 20</h3>
                        </div>
                        <i class="fas fa-bed fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card Booking -->
        <div class="col-md-3">
            <div class="card bg-warning text-dark h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-muted">Sắp Check-out</h6>
                            <h3 class="fw-bold">3 Phòng</h3>
                        </div>
                        <i class="fas fa-clock fa-2x opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card Services -->
        <div class="col-md-3">
            <div class="card bg-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white-50">Dịch vụ đã bán</h6>
                            <h3 class="fw-bold">15 Order</h3>
                        </div>
                        <i class="fas fa-coffee fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white fw-bold">Biểu đồ doanh thu tháng (Demo)</div>
                <div class="card-body d-flex justify-content-center align-items-center"
                    style="height: 300px; background: #f8f9fa;">
                    <span class="text-muted">Khu vực hiển thị ChartJS (Canvas)</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white fw-bold">Hoạt động gần đây</div>
                <ul class="list-group list-group-flush small">
                    <li class="list-group-item">NV A vừa check-in phòng 101 <span class="text-muted float-end">5p
                            trước</span></li>
                    <li class="list-group-item">NV B thêm dịch vụ phòng 202 <span class="text-muted float-end">10p
                            trước</span></li>
                    <li class="list-group-item">Quản lý cập nhật giá phòng <span class="text-muted float-end">1h
                            trước</span></li>
                </ul>
            </div>
        </div>
    </div>
@endsection
