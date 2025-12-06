{{-- resources/views/components/room-partials/occupied.blade.php --}}

@php
    // Lấy booking từ relation đã load sẵn
    $booking = $room->activeBooking;

    // Tính toán hiển thị (Có thể dùng Accessor trong Model để gọn hơn)
    $roomPrice = $booking->total_price ?? 0;
    $servicePrice = $booking->booking ?? 0;
    $total = $roomPrice + $servicePrice;
@endphp

<!-- Khu vực hiển thị tiền (Click vào để thêm dịch vụ) -->
<div class="bg-white rounded p-2 mb-2 border border-danger border-opacity-25 shadow-sm cursor-pointer"
    onclick="openModal('addServiceModal', '{{ $room->id }}')" title="Bấm để thêm dịch vụ">

    <div class="d-flex justify-content-between align-items-center mb-1">
        <small class="text-muted">Tiền phòng:</small>
        <span class="fw-bold text-dark">{{ number_format($roomPrice) }}</span>
    </div>

    <div class="d-flex justify-content-between align-items-center">
        <small class="text-muted">Dịch vụ:</small>
        <span class="fw-bold text-primary">{{ number_format($servicePrice) }}</span>
    </div>

    <div class="border-top mt-1 pt-1 d-flex justify-content-between align-items-center">
        <small class="fw-bold text-danger" style="font-size: 0.75rem">TẠM TÍNH:</small>
        <small class="fw-bold text-danger fs-6">{{ number_format($total) }}</small>
    </div>
</div>

<!-- Nút thao tác nhanh -->
<div class="row g-1">
    <div class="col-6">
        <button class="btn btn-outline-primary w-100 btn-sm p-1"
            onclick="openModal('addServiceModal', '{{ $room->number }}')" title="Thêm dịch vụ">
            <i class="fas fa-cart-plus"></i> <small>Menu</small>
        </button>
    </div>
    <div class="col-6">
        <button class="btn btn-danger w-100 btn-sm p-1" onclick="openCheckoutModal('{{ $room->number }}')"
            title="Thanh toán">
            <i class="fas fa-money-bill-wave"></i> <small>Trả phòng</small>
        </button>
    </div>
</div>

<!-- Thời gian check-in -->
<div class="text-center mt-2 small text-muted">
    <i class="far fa-clock me-1"></i> Vào:
    {{ $booking ? \Carbon\Carbon::parse($booking->checkin_time)->format('H:i d/m') : '--:--' }}
</div>
