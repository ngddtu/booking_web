@extends('components.layout')

@section('title', 'Quản lý Nhân viên')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-users-cog"></i> Danh sách Nhân viên</h5>
            <button onclick="openModal('staffModal')" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Thêm nhân viên
            </button>
        </div>
        
        @if (session()->has('error'))
            <div class="container container--narrow mt-3">
                <div class="alert alert-danger text-center">
                    {{ session('error') }}
                </div>
            </div>
        @endif
        @if (session()->has('success'))
            <div class="container container--narrow mt-3">
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            </div>
        @endif
        @if ($errors->any())
            <div class="container container--narrow mt-3">
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3">ID</th>
                            <th>Họ tên</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Ngày tạo</th>
                            <th class="text-end pe-3">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($staffs as $staff)
                            <tr>
                                <td class="ps-3 fw-bold">#{{ $staff->id }}</td>
                                <td>
                                    <div class="fw-bold">{{ $staff->name }}</div>
                                </td>
                                <td>{{ $staff->email }}</td>
                                <td>{{ $staff->phone }}</td>
                                <td>{{ $staff->created_at ? $staff->created_at->format('d/m/Y') : 'N/A' }}</td>
                                <td class="text-end pe-3">
                                    <button onclick="openEditStaffModal({{ $staff->id }})" class="btn btn-sm btn-outline-info me-1" title="Sửa">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    <form action="{{ route('room.manage-staff.destroy', $staff->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa nhân viên này?');" style="display:inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Chưa có nhân viên nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-3">
                {{ $staffs->links() }}
            </div>
        </div>
    </div>

    {{-- Modal Thêm Nhân viên --}}
    <div class="modal fade" id="staffModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Thêm Nhân viên Mới</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('room.manage-staff.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Họ và Tên</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Số điện thoại</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mật khẩu</label>
                            <input type="password" name="password" class="form-control" required minlength="6">
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Hủy</button>
                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Sửa Nhân viên --}}
    <div class="modal fade" id="editStaffModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-user-edit"></i> Sửa thông tin Nhân viên</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editStaffForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Họ và Tên</label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" id="edit_email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Số điện thoại</label>
                            <input type="text" name="phone" id="edit_phone" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mật khẩu mới (Để trống nếu không đổi)</label>
                            <input type="password" name="password" class="form-control" minlength="6" placeholder="Nhập để đổi mật khẩu...">
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Hủy</button>
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        const staffs = @json($staffs->keyBy('id'));

        function openEditStaffModal(id) {
            const data = staffs[id];
            // Update form action
            document.getElementById('editStaffForm').action = `/room/manage-staff/update/${data.id}`;
            
            // Populate fields
            document.getElementById('edit_name').value = data.name;
            document.getElementById('edit_email').value = data.email;
            document.getElementById('edit_phone').value = data.phone;

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('editStaffModal'));
            modal.show();
        }
    </script>
@endsection
