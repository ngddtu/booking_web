@extends('components.layout')

@section('title', 'Quản lý phòng danh sách phòng')


@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-bed"></i> Danh sách Phòng</h5>
            {{-- Form lọc --}}
            <form method="POST" action="" class="border rounded p-3 bg-light mb-3">
                @csrf
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-primary">Số phòng</label>
                        <input type="text" name="room_number" value="{{ request('room_number') }}" class="form-control"
                            placeholder="VD: 101">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-primary">Loại phòng</label>
                        <select name="type_id" class="form-select">
                            <option value="">-- Tất cả --</option>
                            @foreach ($roomTypes as $type)
                                <option value="{{ $type->id }}" {{ request('type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-primary">Trạng thái</label>
                        <select name="status" class="form-select">
                            <option value="">-- Tất cả --</option>
                            <option value="available">Sẵn sàng
                            </option>
                            <option value="occupied">Có khách
                            </option>
                            <option value="maintenance">Bảo trì
                            </option>
                            <option value="cleaning">Dọn dẹp
                            </option>
                            {{-- <option value="booked">Được đặt</option> --}}
                            <option value="disable">Bị khóa</option>
                        </select>
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i> Lọc</button>
                    </div>
                </div>
            </form>

            <button onclick="openModal('roomModal')" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Thêm phòng mới
            </button>
        </div>
        @if (session()->has('error'))
            <div class="container container--narrow">
                <div class="alert alert-danger text-center">
                    {{ session('error') }}
                </div>
            </div>
        @endif
        @if (session()->has('success'))
            <div class="container container--narrow">
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <div class="card-body p-0">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-3">Số phòng</th>
                        <th>Loại phòng</th>
                        <th>Giá giờ đầu</th>
                        <th>Giá qua đêm</th>
                        <th>Giá theo ngày</th>
                        <th>Phụ trội/h</th>
                        <th>Trạng thái</th>
                        <th class="text-end pe-3">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rooms as $room)
                        <tr>
                            <td class="ps-3 fw-bold">{{ $room->room_number }}</td>
                            <td>{{ $room->typeRoom->name }}</td>
                            <td>{{ number_format($room->typeRoom->initial_hour_rate) }}</td>
                            <td>{{ number_format($room->typeRoom->overnight_rate) }}</td>
                            <td>{{ number_format($room->typeRoom->daily_rate) }}</td>
                            <td>{{ number_format($room->typeRoom->late_checkout_fee_value) }}</td>
                            <td><span class="badge bg-{{ $room->status_badge }}">{{ $room->status_label }}</span></td>
                            <td class="text-end pe-3">
                                @if ($room->status != 'occupied')
                                    <button onclick="openEditRoomModal({{ $room->id }})"
                                        class="btn btn-sm btn-outline-info"><i class="fas fa-pen"></i></button>
                                    {{-- <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button> --}}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    {{-- <tr>
                        <td class="ps-3 fw-bold">102</td>
                        <td>Đôi (Deluxe)</td>
                        <td>90.000 ₫</td>
                        <td>350.000 ₫</td>
                        <td><span class="badge bg-danger">Đang có khách</span></td>
                        <td class="text-end pe-3">
                            <button class="btn btn-sm btn-outline-secondary" disabled><i class="fas fa-pen"></i></button>
                        </td>
                    </tr> --}}

                </tbody>
            </table>
            <div>
                {{ $rooms->links() }}
            </div>
        </div>
    </div>




    {{-- Modal thêm phòng --}}
    <div class="modal fade" id="roomModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Thông tin phòng</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('room.manage-room.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Số phòng</label>
                                <input type="text" name="room_number" class="form-control" placeholder="VD: 101">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Trạng thái</label>
                                <select class="form-select" name="status">
                                    <option value="available">Sẵn sàng (Trống)</option>
                                    {{-- <option value="occupied">Có khách</option> --}}
                                    <option value="maintenance">Đang bảo trì</option>
                                    <option value="cleaning">Đang dọn dẹp</option>
                                    <option value="booked">Được đặt trước</option>
                                    <option value="disable">Bị khóa</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Loại phòng</label>
                            <select name="room_type_id" class="form-select">
                                <option value="">-- Tất cả --</option>
                                @foreach ($roomTypes as $type)
                                    <option value="{{ $type->id }}"
                                        {{ request('type_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text"><a href="{{ route('room.manage-type-room') }}">+ Quản lý loại phòng</a>
                            </div>
                        </div>

                        {{-- <div class="p-3 bg-light rounded border">
                            <h6 class="small fw-bold text-muted mb-3">CẤU HÌNH GIÁ (Ghi đè giá gốc nếu cần)</h6>
                            <div class="row g-2">
                                <div class="col-4">
                                    <label class="small text-secondary">Giờ đầu</label>
                                    <input type="number" class="form-control form-control-sm" value="70000">
                                </div>
                                <div class="col-4">
                                    <label class="small text-secondary">Qua đêm</label>
                                    <input type="number" class="form-control form-control-sm" value="250000">
                                </div>
                                <div class="col-4">
                                    <label class="small text-secondary">Theo ngày</label>
                                    <input type="number" class="form-control form-control-sm" value="400000">
                                </div>
                            </div>
                        </div> --}}

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu thông tin</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal sửa phòng --}}
    <div class="modal fade" id="editRoomModal" tabindex="-1">
        <form id="editRoomForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title"><i class="fas fa-pen"></i> Sửa thông tin phòng</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        {{-- Số phòng --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Số phòng</label>
                            <input type="text" name="room_number" id="edit_room_number" class="form-control"
                                placeholder="VD: 101" value="{{ old('room_number') }}">
                            @error('room_number')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Loại phòng --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Loại phòng</label>
                            <select name="type_room_id" id="edit_type_room_id" class="form-select">
                                @foreach ($roomTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                            @error('type_room_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Trạng thái --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Trạng thái</label>
                            <select name="status" id="edit_status" class="form-select">
                                <option value="available">Sẵn sàng</option>
                                {{-- <option value="booked">Đặt trước</option> --}}
                                {{-- <option value="occupied">Có khách</option> --}}
                                <option value="maintenance">Đang bảo trì</option>
                                <option value="cleaning">Đang dọn dẹp</option>
                                <option value="disable">Bị khóa</option>
                            </select>
                            @error('status')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        const rooms = @json($rooms->keyBy('id')); // truyền danh sách phòng từ controller
        console.log(rooms);

        function openEditRoomModal(id) {
            const data = rooms[id];
            document.getElementById('editRoomForm').action = `/room/manage-room/update/${data.id}`;
            document.getElementById('edit_room_number').value = data.room_number;
            document.getElementById('edit_type_room_id').value = data.type_room.id;
            console.log(data.type_room.name);

            document.getElementById('edit_status').value = data.status;

            const modal = new bootstrap.Modal(document.getElementById('editRoomModal'));
            modal.show();
        }
    </script>
@endsection
