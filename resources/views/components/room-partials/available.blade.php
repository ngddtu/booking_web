{{-- resources/views/components/room-partials/available.blade.php --}}



{{-- HIỂN THỊ BOOKING SẮP TỚI --}}
<div class="border rounded p-2 small bg-white shadow-sm mt-2">

    @php
        // Lấy đơn booking có thời gian check-in còn ở tương lai
        $upcoming = $room->activeBookings->where('check_in', '>', now())->sortBy('check_in')->first();
    @endphp

    @if ($upcoming)
        <div class="fw-bold text-primary mb-1">
            Đơn #{{ $upcoming->id }} - {{ $upcoming->customer->name }}
        </div>

        <div class="d-flex justify-content-between small text-muted">
            <span><i class="fas fa-clock me-1"></i>Check-in:</span>
            <span>{{ \Carbon\Carbon::parse($upcoming->check_in)->format('d/m H:i') }}</span>
        </div>

        <div class="d-flex justify-content-between small text-muted">
            <span><i class="fas fa-sign-out-alt me-1"></i>Check-out:</span>
            <span>{{ \Carbon\Carbon::parse($upcoming->check_out)->format('d/m H:i') }}</span>
        </div>
    @else
        <div class="text-center text-muted">
            <i class="fas fa-info-circle me-1"></i>
            Không có booking sắp tới
        </div>
    @endif
</div>


{{-- BẢNG GIÁ --}}
<div class="border rounded p-2 small bg-white shadow-sm mt-2">
    <div class="fw-bold text-success mb-1">Bảng giá</div>
    <div class="d-flex justify-content-between">
        <span><i
                class="fas fa-clock me-1 text-success"></i>{{ number_format($room->roomType->initial_hour_rate) }}₫</span>
        <span><i class="fas fa-moon me-1 text-primary"></i>{{ number_format($room->roomType->overnight_rate) }}₫</span>
        <span><i
                class="fas fa-calendar-day me-1 text-warning"></i>{{ number_format($room->roomType->daily_rate) }}₫</span>
    </div>
</div>

{{-- INFO --}}
<div class="d-flex justify-content-between text-muted small mt-2 border-top pt-2">
    <span><i class="fas fa-user-friends me-1"></i>Max: {{ $room->roomType->max_people ?? 2 }}</span>
    <span class="text-success"><i class="fas fa-check-circle me-1"></i>Sạch sẽ</span>
</div>
{{-- Nút nhận khách (compact) --}}
<div class="text-center mt-2">
    <button class="btn btn-success btn-sm px-3 py-1 shadow-sm rounded-pill"
        onclick="openCheckinModal({{ $room->id }}, '{{ $room->room_number }}')">
        <i class="fas fa-plus-circle me-1"></i> Nhận khách
    </button>
</div>
