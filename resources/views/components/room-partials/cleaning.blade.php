{{-- resources/views/components/room-partials/cleaning.blade.php --}}

@php
    // Lấy booking từ relation đã load sẵn (nếu có)
    $booking = $room->activeBooking;
@endphp

<!-- Khu vực hiển thị thông tin -->
<div class="bg-white rounded p-2 mb-2 border border-warning border-opacity-25 shadow-sm text-center">
    <i class="fas fa-broom fa-2x text-warning mb-2"></i>
    <div class="fw-bold text-dark">Đang dọn dẹp</div>
    <small class="text-muted">Phòng sẽ sẵn sàng sau khi hoàn tất</small>
</div>

<!-- Nút thao tác -->
<div class="row g-1">
    <div class="col-12">
        <form action="" id="finishCleaningForm" method="post"> 
            @csrf
        <button class="btn btn-success w-100 btn-sm p-1" 
                onclick="finishCleaning({{ $room->id }})" 
                title="Hoàn tất dọn dẹp">
            <i class="fas fa-check-circle"></i> <small>Hoàn tất dọn dẹp</small>
        </button>
    </form>
    </div>
</div>

<!-- Thông tin -->
{{-- @if($booking)
<div class="text-center mt-2 small text-muted">
    <i class="far fa-clock me-1"></i> Check-out: {{ \Carbon\Carbon::parse($booking->check_out)->format('H:i d/m') ?? '--:--' }}
</div>
@endif --}}
