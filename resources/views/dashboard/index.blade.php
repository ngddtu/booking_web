@extends('components.layout')

@section('title', 'Tổng quan Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-subtitle mb-2 text-white-50">Tổng Doanh Thu</h6>
                            <h3 class="card-title fw-bold">{{ number_format($totalRevenue, 0, ',', '.') }} VNĐ</h3>
                        </div>
                        <i class="fas fa-coins fa-2x text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-subtitle mb-2 text-white-50">Tổng Đơn Đặt</h6>
                            <h3 class="card-title fw-bold">{{ $totalBookings }}</h3>
                        </div>
                        <i class="fas fa-calendar-check fa-2x text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-subtitle mb-2 text-white-50">Khách Hàng</h6>
                            <h3 class="card-title fw-bold">{{ $totalCustomers }}</h3>
                        </div>
                        <i class="fas fa-users fa-2x text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-warning text-dark h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-subtitle mb-2 text-dark-50">Phòng Đắt Khách Nhất</h6>
                            <h3 class="card-title fw-bold">{{ $topRooms->first()->room->room_number ?? 'N/A' }}</h3>
                        </div>
                        <i class="fas fa-trophy fa-2x text-dark-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Top Booked Rooms Table -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-primary"><i class="fas fa-medal me-2"></i>Top 5 Phòng Được Đặt Nhiều Nhất</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-3">Phòng</th>
                                    <th>Loại phòng</th>
                                    <th class="text-center">Số lượt đặt</th>
                                    {{-- <th class="text-end pe-3">Doanh thu</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topRooms as $stat)
                                <tr>
                                    <td class="ps-3 fw-bold text-primary">{{ $stat->room->room_number }}</td>
                                    <td><span class="badge bg-secondary">{{ $stat->room->roomType->name ?? 'N/A' }}</span></td>
                                    <td class="text-center fw-bold">{{ $stat->total }}</td>
                                    {{-- <td class="text-end pe-3 text-success fw-bold">TODO</td> --}}
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-3 text-muted">Chưa có dữ liệu</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Bookings -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-primary"><i class="fas fa-clock me-2"></i>Đơn Đặt Mới Nhất</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-3">Khách hàng</th>
                                    <th>Phòng</th>
                                    <th>Check-in</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentBookings as $booking)
                                <tr>
                                    <td class="ps-3">
                                        <div class="fw-bold">{{ $booking->customer->name ?? 'Khách vãng lai' }}</div>
                                        <small class="text-muted">{{ $booking->customer->phone ?? '' }}</small>
                                    </td>
                                    <td>{{ $booking->room->room_number }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->check_in)->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if($booking->status == 'pending')
                                            <span class="badge bg-warning text-dark">Chờ xử lý</span>
                                        @elseif($booking->status == 'confirmed')
                                            <span class="badge bg-primary">Đã xác nhận</span>
                                        @elseif($booking->status == 'completed')
                                            <span class="badge bg-success">Hoàn thành</span>
                                        @elseif($booking->status == 'canceled')
                                            <span class="badge bg-danger">Đã hủy</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-3 text-muted">Chưa có dữ liệu</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
