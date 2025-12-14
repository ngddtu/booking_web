{{-- resources/views/components/room-partials/booked.blade.php --}}

@php
    // Lấy booking từ relation đã load sẵn
    $booking = $room->activeBooking;
    
    // Tính toán hiển thị
    $roomPrice = $booking->total_price ?? 0;
    $servicePrice = $room->service_price ?? 0;
    $total = $roomPrice + $servicePrice;
@endphp

<!-- Khu vực hiển thị thông tin đặt trước -->
<div class="bg-white rounded p-2 mb-2 border border-primary border-opacity-25 shadow-sm">
    
    <div class="d-flex justify-content-between align-items-center mb-1">
        <small class="text-muted">Khách hàng:</small>
        <span class="fw-bold text-dark">{{ $booking->customer->name ?? 'N/A' }}</span>
    </div>
    
    <div class="d-flex justify-content-between align-items-center">
        <small class="text-muted">SĐT:</small>
        <span class="fw-bold text-primary">{{ $booking->customer->phone ?? '---' }}</span>
    </div>
    
    @if($booking && $booking->check_in)
    <div class="border-top mt-1 pt-1 d-flex justify-content-between align-items-center">
        <small class="fw-bold text-primary" style="font-size: 0.75rem">Check-in:</small>
        <small class="fw-bold text-primary fs-6">{{ \Carbon\Carbon::parse($booking->check_in)->format('H:i d/m') }}</small>
    </div>
    @endif
</div>

<!-- Nút thao tác nhanh -->
<div class="row g-1">
    <div class="col-12">
        <button class="btn btn-success w-100 btn-sm p-1" 
                onclick="openCheckinModal({{ $room->id }}, '{{ $room->room_number }}')" 
                title="Nhận phòng">
            <i class="fas fa-key"></i> <small>Nhận phòng</small>
        </button>
    </div>
</div>

<!-- Thời gian đặt trước -->
<div class="text-center mt-2 small text-muted">
    <i class="far fa-calendar me-1"></i> Đặt trước: {{ $booking ? \Carbon\Carbon::parse($booking->created_at)->format('H:i d/m') : '--:--' }}
</div>
