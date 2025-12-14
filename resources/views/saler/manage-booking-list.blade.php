@extends('components.layout')

@section('title', 'Quản lý Booking')

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-primary">
                <i class="fas fa-calendar-check me-2"></i>Danh sách Booking
            </h5>

            {{-- <a href="{{ route('bookings.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus-circle me-1"></i> Tạo Booking
        </a> --}}
        </div>

        <div class="card-body">
            <div class="row g-2 mb-3">
                <div class="col-md-4">
                    <input type="text" id="bookingSearchInput" class="form-control form-control-sm"
                        placeholder="Tìm theo tên hoặc SĐT khách hàng...">
                </div>

                <div class="col-md-3">
                    <select id="bookingRankFilter" class="form-select form-select-sm">
                        <option value="">-- Rank khách --</option>
                        <option value="normal">Khách thường</option>
                        <option value="vip">VIP</option>
                        <option value="blacklist">Blacklist</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <select id="bookingStatusFilter" class="form-select form-select-sm">
                        <option value="">-- Trạng thái booking --</option>
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-sm btn-secondary w-100" onclick="resetBookingFilter()">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                </div>
            </div>

            {{-- Bảng dữ liệu --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Mã</th>
                            <th>Khách hàng</th>
                            <th>Phòng</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Hình thức</th>
                            <th>Trạng thái</th>
                            <th class="text-end">Hành động</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($bookings as $booking)
                            <tr data-name="{{ strtolower($booking->customer->name) }}"
                                data-phone="{{ $booking->customer->phone }}" data-rank="{{ $booking->customer->rank }}"
                                data-status="{{ $booking->status }}">
                                <td>#{{ $booking->id }}</td>

                                <td>
                                    <b>{{ $booking->customer->name }}</b>
                                    <div class="small text-muted">{{ $booking->customer->phone }}</div>
                                </td>

                                <td>
                                    <span class="badge bg-primary">{{ $booking->room->room_number }}</span>
                                </td>

                                <td>{{ \Carbon\Carbon::parse($booking->check_in)->format('d/m/Y H:i') }}</td>
                                <td>
                                    {{ $booking->check_out ? \Carbon\Carbon::parse($booking->check_out)->format('d/m/Y H:i') : '-' }}
                                </td>

                                <td>{{ ucfirst($booking->rent_type) }}</td>

                                <td>
                                    @php
                                        $statusColor =
                                            [
                                                'pending' => 'warning',
                                                'confirmed' => 'success',
                                                'cancelled' => 'danger',
                                                'completed' => 'secondary',
                                            ][$booking->status] ?? 'dark';
                                    @endphp

                                    <span class="badge bg-{{ $statusColor }}">
                                        {{ strtoupper($booking->status) }}
                                    </span>
                                </td>

                                <td class="text-end">
                                    <button class="btn btn-sm btn-info"
                                        onclick="openViewBookingModal({{ $booking->id }})">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <button class="btn btn-sm btn-warning"
                                        onclick="openEditBookingModal({{ $booking->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button class="btn btn-sm btn-danger" onclick="rejectCheckin({{ $booking->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Không có booking nào.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Phân trang --}}
            <div class="mt-3">
                {{ $bookings->links() }}
            </div>
        </div>
    </div>
    <form id="confirmCheckinForm" method="POST" style="display: none;">
        @csrf
    </form>

    <form id="rejectCheckinForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>




    {{-- MODAL: VIEW BOOKING --}}
    <div class="modal fade" id="viewBookingModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content shadow border-0">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-receipt me-2"></i>Chi tiết Booking
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="small text-muted">Khách hàng</label>
                            <div class="fw-bold" id="view_customer_name">---</div>
                        </div>

                        <div class="col-md-6">
                            <label class="small text-muted">Số điện thoại</label>
                            <div class="fw-bold" id="view_customer_phone">---</div>
                        </div>

                        <div class="col-md-6">
                            <label class="small text-muted">Check-in</label>
                            <div class="fw-bold" id="view_check_in">---</div>
                        </div>

                        <div class="col-md-6">
                            <label class="small text-muted">Check-out</label>
                            <div class="fw-bold" id="view_check_out">---</div>
                        </div>

                        <div class="col-md-4">
                            <label class="small text-muted">Hình thức thuê</label>
                            <div class="fw-bold" id="view_rent_type">---</div>
                        </div>

                        <div class="col-md-4">
                            <label class="small text-muted">Tổng tiền</label>
                            <div class="fw-bold text-success" id="view_total_price">---</div>
                        </div>

                        <div class="col-md-4">
                            <label class="small text-muted">Trạng thái</label>
                            <span class="badge bg-info" id="view_status">---</span>
                        </div>

                        <div class="col-12">
                            <label class="small text-muted">Ghi chú</label>
                            <div class="border rounded p-2 bg-light" id="view_note">---</div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                        Đóng
                    </button>
                </div>

            </div>
        </div>
    </div>

    {{-- MODAL: EDIT BOOKING --}}
    <div class="modal fade" id="editBookingModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content shadow border-0">

                <form method="POST" id="editBookingForm">
                    @csrf
                    @method('PUT')

                    <div class="modal-header bg-warning">
                        <h5 class="modal-title">
                            <i class="fas fa-edit me-2"></i>Sửa Booking
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small">Check-in</label>
                                <input type="datetime-local" class="form-control" name="check_in" id="edit_check_in">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small">Check-out</label>
                                <input type="datetime-local" class="form-control" name="check_out" id="edit_check_out">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small">Hình thức thuê</label>
                                <select class="form-select" name="rent_type" id="edit_rent_type">
                                    <option value="hourly">Theo giờ</option>
                                    <option value="overnight">Qua đêm</option>
                                    <option value="daily">Theo ngày</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small">Tổng tiền</label>
                                <input type="number" class="form-control" name="total_price" id="edit_total_price">
                            </div>

                            <div class="col-12">
                                <label class="form-label small">Ghi chú</label>
                                <textarea class="form-control" rows="2" name="note" id="edit_note"></textarea>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                            Hủy
                        </button>
                        <button type="submit" class="btn btn-warning btn-sm fw-bold">
                            Lưu thay đổi
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection


@section('script')
    <script>
        function confirmDelete(id) {
            const form = document.getElementById('deleteForm');
            form.action = `/bookings/${id}`;

            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }
        const bookings = @json($bookings->keyBy('id'));
        console.log(bookings[1]);


        function openViewBookingModal(id) {
            const booking = bookings[id];
            document.getElementById('view_customer_name').innerText = booking.customer.name;
            document.getElementById('view_customer_phone').innerText = booking.customer.phone;
            document.getElementById('view_check_in').innerText = booking.check_in;
            document.getElementById('view_check_out').innerText = booking.check_out ?? '—';
            document.getElementById('view_rent_type').innerText = booking.rent_type;
            document.getElementById('view_total_price').innerText =
                Number(booking.total_price).toLocaleString() + 'đ';
            document.getElementById('view_status').innerText = booking.status;
            document.getElementById('view_note').innerText = booking.note ?? 'Không có';

            new bootstrap.Modal(document.getElementById('viewBookingModal')).show();
        }



        function openEditBookingModal(id) {
            // document.getElementById('editBookingForm').action =
            //     updateUrlTemplate.replace(':id', booking.id);

            const booking = bookings[id];

            document.getElementById('edit_check_in').value = booking.check_in.replace(' ', 'T');
            document.getElementById('edit_check_out').value =
                booking.check_out ? booking.check_out.replace(' ', 'T') : '';
            document.getElementById('edit_rent_type').value = booking.rent_type;
            document.getElementById('edit_total_price').value = Number(booking.total_price).toLocaleString();
            document.getElementById('edit_note').value = booking.note ?? '';

            new bootstrap.Modal(document.getElementById('editBookingModal')).show();
        }


        const bookingSearchInput = document.getElementById('bookingSearchInput');
        const bookingRankFilter = document.getElementById('bookingRankFilter');
        const bookingStatusFilter = document.getElementById('bookingStatusFilter');
        const bookingRows = document.querySelectorAll('table tbody tr');

        function filterBookings() {
            const keyword = bookingSearchInput.value.toLowerCase();
            const rank = bookingRankFilter.value;
            const status = bookingStatusFilter.value;

            bookingRows.forEach(row => {
                const name = row.dataset.name || '';
                const phone = row.dataset.phone || '';
                const rowRank = row.dataset.rank || '';
                const rowStatus = row.dataset.status || '';

                let match = true;

                // Tìm theo tên hoặc SĐT
                if (keyword && !name.includes(keyword) && !phone.includes(keyword)) {
                    match = false;
                }

                // Rank khách hàng
                if (rank && rowRank !== rank) {
                    match = false;
                }

                // Trạng thái booking
                if (status && rowStatus !== status) {
                    match = false;
                }

                row.style.display = match ? '' : 'none';
            });
        }

        function resetBookingFilter() {
            bookingSearchInput.value = '';
            bookingRankFilter.value = '';
            bookingStatusFilter.value = '';
            filterBookings();
        }

        bookingSearchInput.addEventListener('input', filterBookings);
        bookingRankFilter.addEventListener('change', filterBookings);
        bookingStatusFilter.addEventListener('change', filterBookings);
    </script>
@endsection
