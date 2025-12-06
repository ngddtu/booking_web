{{-- resources/views/components/room-partials/available.blade.php --}}

<div class="bg-white rounded p-2 text-center mb-2 cursor-pointer hover-shadow border border-success border-opacity-25"
     onclick="openModal('checkinModal', '{{ $room->number }}')">
    <div class="py-2">
        <i class="fas fa-plus-circle text-success fs-3 mb-1"></i>
        <div class="small fw-bold text-dark text-uppercase">Nhận khách</div>
    </div>
</div>

<div class="d-flex justify-content-between text-muted small mt-2 border-top pt-2">
    <span><i class="fas fa-user-friends me-1"></i>Max: {{ $room->capacity ?? 2 }}</span>
    <span class="text-success"><i class="fas fa-check-circle me-1"></i>Sạch sẽ</span>
</div>