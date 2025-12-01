@extends('components.layout')


@section('title', 'Quản lý danh sách loại phòng')

{{-- @endsection --}}
@section('content')
    <!-- VIEW: MANAGE ROOM TYPES (QUẢN LÝ LOẠI PHÒNG) -->
    <div class="card-header bg-white py-3">
        <div class="row align-items-center g-2">
            <!-- 1. Tiêu đề (3 phần) -->
            <div class="col-md-3">
                <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-shapes text-primary"></i> Loại phòng</h5>
            </div>

            <form action="" method="POST">
                <div class="row align-items-center g-2">
                    @csrf
                    <!-- 2. Tìm kiếm theo TÊN -->
                    <div class="col-md-3">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light"><i class="fas fa-search"></i></span>
                            <input type="text" name="name" id="searchName" class="form-control"
                                placeholder="Tìm tên (VD: VIP)...">
                        </div>
                    </div>

                    <!-- 3. Tìm kiếm theo SỐ NGƯỜI -->
                    <div class="col-md-3">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light"><i class="fas fa-users"></i></span>
                            <input type="number" name="people" id="searchPeople" class="form-control"
                                placeholder="Tìm số người (VD: 4)...">
                        </div>
                    </div>

                    <!-- 4. Nút Submit -->
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-success btn-sm w-100">
                            <i class="fas fa-filter"></i> Lọc
                        </button>
                    </div>

                </div>
            </form>


            <!-- 4. Nút Thêm (3 phần) -->
            <div class="col-md-3 text-md-end text-start">
                <button class="btn btn-primary btn-sm w-100" onclick="openModal('roomTypeModal')">
                    <i class="fas fa-plus"></i> Thêm mới
                </button>
            </div>
        </div>
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
        <div class="table-responsive">
            <!-- Thêm ID="roomTypeTable" vào bảng để JS xử lý -->
            <table class="table table-hover table-bordered align-middle mb-0" id="roomTypeTable">
                <thead class="bg-light text-secondary">
                    <tr>
                        <th class="ps-3">Tên Loại phòng</th>
                        <th class="ps-3">Số phòng</th>
                        <th class="text-center" style="width: 100px;">Số người</th>
                        <th>Giá giờ đầu</th>
                        <th>Giá qua đêm</th>
                        <th>Giá theo ngày</th>
                        <th>Phụ trội (Sau 12h)</th>
                        <th>Trạng thái</th>
                        <th class="text-end pe-3">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dữ liệu cứng 1: Phòng Đơn -->
                    @foreach ($typerooms as $type)
                        <tr>
                            <td class="ps-3">
                                <div class="fw-bold text-primary">{{ $type->name }}</div>
                                <small class="text-muted">{{ $type->description }}</small>
                            </td>
                            <td>
                                {{ number_format($type->rooms_count) }}
                            </td>
                            <td class="text-center"><i class="fas fa-user"></i>x{{ $type->max_people }}</td>
                            <td class="fw-bold text-dark">{{ number_format($type->initial_hour_rate) }}VNĐ</td>
                            <td class="fw-bold text-success">{{ number_format($type->overnight_rate) }}VNĐ</td>
                            <td class="fw-bold text-info">{{ number_format($type->daily_rate) }}VNĐ</td>
                            <td class="text-muted small">{{ number_format($type->late_checkout_fee_value) }}k/h</td>
                            <td><span
                                    class="{{ $type->status == 'available' ? 'badge bg-success' : 'badge bg-danger' }}">{{ $type->status == 'available' ? 'Sẵn sàng' : 'Bị khóa' }}</span>
                            </td>
                            <td class="text-end pe-3">
                                <button onclick="openEditModal({{ $type->id }})" class="btn btn-sm btn-light border"
                                    title="Sửa"><i class="fas fa-pen text-primary"></i></button>
                                <button class="btn btn-sm btn-light border" title="Xóa"><i
                                        class="fas fa-trash text-danger"></i></button>
                            </td>
                        </tr>
                    @endforeach

                    {{-- <!-- Dữ liệu cứng 2: Phòng Đôi -->
                    <tr>
                        <td class="ps-3">
                            <div class="fw-bold text-primary">Deluxe (Đôi)</div>
                            <small class="text-muted">Phòng rộng, cửa sổ lớn</small>
                        </td>
                        <td class="text-center"><i class="fas fa-user"></i> x4</td>
                        <td class="fw-bold text-dark">90.000 ₫</td>
                        <td class="fw-bold text-success">350.000 ₫</td>
                        <td class="fw-bold text-info">550.000 ₫</td>
                        <td class="text-muted small">30k/h</td>
                        <td class="text-end pe-3">
                            <button class="btn btn-sm btn-light border"><i class="fas fa-pen text-primary"></i></button>
                            <button class="btn btn-sm btn-light border"><i class="fas fa-trash text-danger"></i></button>
                        </td>
                    </tr>

                    <!-- Dữ liệu cứng 3: Phòng VIP -->
                    <tr>
                        <td class="ps-3">
                            <div class="fw-bold text-warning">VIP (Gia đình)</div>
                            <small class="text-muted">Nội thất cao cấp, 2 giường lớn</small>
                        </td>
                        <td class="text-center"><i class="fas fa-user"></i> x6</td>
                        <td class="fw-bold text-dark">150.000 ₫</td>
                        <td class="fw-bold text-success">600.000 ₫</td>
                        <td class="fw-bold text-info">900.000 ₫</td>
                        <td class="text-muted small">50k/h</td>
                        <td class="text-end pe-3">
                            <button class="btn btn-sm btn-light border"><i class="fas fa-pen text-primary"></i></button>
                            <button class="btn btn-sm btn-light border"><i class="fas fa-trash text-danger"></i></button>
                        </td>
                    </tr> --}}
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white text-muted small">
        <i class="fas fa-info-circle"></i> Giá phòng sẽ được áp dụng tự động khi tạo booking mới.
    </div>
    <div>
        {{ $typerooms->links() }}
    </div>

    {{-- Modall thêm loại phòng --}}
    <div class="modal fade" id="roomTypeModal" tabindex="-1">
        <form action="{{ route('room.manage-type-room.store') }}" method="POST">
            @csrf
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title"><i class="fas fa-shapes"></i> Thông tin Loại phòng</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tên loại phòng</label>
                            <input type="text" name="name" class="form-control" placeholder="VD: Phòng Đôi (Deluxe)"
                                value="{{ old('name') }}">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="form-label small text-muted">Số người tối đa</label>
                                <input type="number" name="max_people" class="form-control"
                                    value="{{ old('max_people', 2) }}">
                                @error('max_people')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            {{-- <div class="col-6">
                                <label class="form-label small text-muted">Phụ thu quá người</label>
                                <input type="number" name="extra_person_fee" class="form-control"
                                    value="{{ old('extra_person_fee') }}">
                                @error('extra_person_fee')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div> --}}
                        </div>

                        <div class="p-3 bg-light rounded border mb-3">
                            <h6 class="small fw-bold text-primary mb-3"><i class="fas fa-tag"></i> BẢNG GIÁ NIÊM YẾT</h6>

                            <div class="mb-2 row align-items-center">
                                <label class="col-sm-4 col-form-label small">Giá giờ đầu:</label>
                                <div class="col-sm-8">
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="initial_hour_rate" class="form-control"
                                            value="{{ old('initial_hour_rate') }}">
                                        <span class="input-group-text">VNĐ</span>
                                    </div>
                                    @error('initial_hour_rate')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-2 row align-items-center">
                                <label class="col-sm-4 col-form-label small">Giá qua đêm:</label>
                                <div class="col-sm-8">
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="overnight_rate" class="form-control"
                                            value="{{ old('overnight_rate') }}">
                                        <span class="input-group-text">VNĐ</span>
                                    </div>
                                    @error('overnight_rate')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-2 row align-items-center">
                                <label class="col-sm-4 col-form-label small">Giá theo ngày:</label>
                                <div class="col-sm-8">
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="daily_rate" class="form-control"
                                            value="{{ old('daily_rate') }}">
                                        <span class="input-group-text">VNĐ</span>
                                    </div>
                                    @error('daily_rate')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row align-items-center">
                                <label class="col-sm-4 col-form-label small text-danger">Phụ trội giờ:</label>
                                <div class="col-sm-8">
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="late_checkout_fee_value" class="form-control"
                                            value="{{ old('late_checkout_fee_value') }}">
                                        <span class="input-group-text">VNĐ/h</span>
                                    </div>
                                    @error('late_checkout_fee_value')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small">Mô tả tiện ích</label>
                            <textarea name="description" class="form-control" rows="2" placeholder="VD: Có bồn tắm, view biển...">{{ old('description') }}</textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Trạng thái</label>
                            <select name="status" class="form-select">
                                <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Sẵn sàng
                                </option>
                                <option value="locked" {{ old('status') == 'disable' ? 'selected' : '' }}>Bị khóa</option>
                            </select>
                            @error('status')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu dữ liệu</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- Modal sửa loại phòng --}}
    <div class="modal fade" id="editRoomTypeModal" tabindex="-1">
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            {{-- <input type="hidden" name="type_room_id" id="edit_type_room_id" value="{{ old('type_room_id') }}"> --}}
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title"><i class="fas fa-pen"></i> Sửa loại phòng</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        {{-- Tên loại phòng --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tên loại phòng</label>
                            <input type="text" name="name" class="form-control" id="edit_name_type_room"
                                value="{{ old('name') }}" placeholder="VD: Phòng Đôi (Deluxe)">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Số người tối đa & Phụ thu --}}
                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="form-label small text-muted">Số người tối đa</label>
                                <input type="number" name="max_people" class="form-control" id="max_people"
                                    value="{{ old('max_people') }}">
                                @error('max_people')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            {{-- <div class="col-6">
                                <label class="form-label small text-muted">Phụ thu quá người</label>
                                <input type="number" name="extra_person_fee" class="form-control" id="extra_person_fee"
                                    value="{{ old('extra_person_fee') }}">
                                @error('extra_person_fee')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div> --}}
                        </div>

                        {{-- Bảng giá --}}
                        <div class="p-3 bg-light rounded border mb-3">
                            <h6 class="small fw-bold text-primary mb-3"><i class="fas fa-tag"></i> BẢNG GIÁ NIÊM YẾT</h6>

                            <div class="mb-2 row align-items-center">
                                <label class="col-sm-4 col-form-label small">Giá giờ đầu:</label>
                                <div class="col-sm-8">
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="initial_hour_rate" class="form-control"
                                            id="initial_hour_rate" value="{{ old('initial_hour_rate') }}"
                                            placeholder="0">
                                        <span class="input-group-text">VNĐ</span>
                                    </div>
                                    @error('initial_hour_rate')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-2 row align-items-center">
                                <label class="col-sm-4 col-form-label small">Giá qua đêm:</label>
                                <div class="col-sm-8">
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="overnight_rate" class="form-control"
                                            id="overnight_rate" value="{{ old('overnight_rate') }}" placeholder="0">
                                        <span class="input-group-text">VNĐ</span>
                                    </div>
                                    @error('overnight_rate')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-2 row align-items-center">
                                <label class="col-sm-4 col-form-label small">Giá theo ngày:</label>
                                <div class="col-sm-8">
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="daily_rate" class="form-control" id="daily_rate"
                                            value="{{ old('daily_rate') }}" placeholder="0">
                                        <span class="input-group-text">VNĐ</span>
                                    </div>
                                    @error('daily_rate')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row align-items-center">
                                <label class="col-sm-4 col-form-label small text-danger">Phụ trội giờ:</label>
                                <div class="col-sm-8">
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="late_checkout_fee_value" class="form-control"
                                            id="late_checkout_fee_value" value="{{ old('late_checkout_fee_value') }}"
                                            placeholder="VD: 20000">
                                        <span class="input-group-text">VNĐ/h</span>
                                    </div>
                                    @error('late_checkout_fee_value')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        {{-- Mô tả --}}
                        <div class="mb-3">
                            <label class="form-label small">Mô tả tiện ích</label>
                            <textarea name="description" id="description" class="form-control" rows="2"
                                placeholder="VD: Có bồn tắm, view biển...">{{ old('description') }}</textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Trạng thái</label>
                            <select name="status" class="form-select" id="status_room_type">
                                <option value="available">Sẵn sàng</option>
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
        const typerooms = @json($typerooms->keyBy('id'));
        console.log(typerooms);


        function openEditModal(id) {
            const data = typerooms[id];
            document.getElementById('editForm').action =
                `/room/manage-type-room/update/${data.id}`;

            // document.getElementById('id_type_room').value = data.id;
            document.getElementById('edit_name_type_room').value = data.name;
            document.getElementById('max_people').value = data.max_people;
            document.getElementById('description').value = data.description;
            document.getElementById('status_room_type').value = data.status;
            document.getElementById('initial_hour_rate').value = data.initial_hour_rate;
            document.getElementById('overnight_rate').value = data.overnight_rate;
            document.getElementById('daily_rate').value = data.daily_rate;
            document.getElementById('late_checkout_fee_value').value = data.late_checkout_fee_value;

            // điền các field khác tương tự

            const modal = new bootstrap.Modal(document.getElementById('editRoomTypeModal'));
            modal.show();
        }
    </script>
@endsection
