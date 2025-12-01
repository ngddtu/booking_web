@extends('components.layout')
@section('title', 'Quản lý dịch vụ')
@section('content')
    <div class="row">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- List Services -->
        <div class="col-md-8">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-success"><i class="fas fa-utensils"></i> Menu Dịch vụ</h5>
                    <input type="text" class="form-control form-control-sm w-25" placeholder="Tìm kiếm...">
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">Tên dịch vụ</th>
                                <th>Đơn vị</th>
                                <th>Đơn giá</th>
                                <th class="text-end pe-3">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($services as $service)
                                <tr>
                                    <td class="ps-3"><i class="fas fa-utensils text-primary me-2"></i>
                                        {{ $service->name }}</td>
                                    <td>{{ $service->unit }}</td>
                                    <td class="fw-bold text-success">{{ number_format($service->price) }} ₫</td>
                                    <td class="text-end pe-3">
                                        <button class="btn btn-sm btn-light border"
                                            onclick="openModalService({{ $service->id }})">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <form action="{{ route('room.manage-services.destroy', $service->id) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa dịch vụ này?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-light border"><i
                                                    class="fas fa-trash text-danger"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Form Add/Edit -->
        <div class="col-md-4">
            <div class="card shadow-sm border-top border-3 border-success">
                <div class="card-header bg-white fw-bold">
                    <i class="fas fa-plus-circle"></i> Thêm Dịch vụ
                </div>
                <div class="card-body">
                    <form action="{{ route('room.manage-services.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small text-muted">Tên dịch vụ</label>
                            <input type="text" name="name" class="form-control" placeholder="VD: Mì xào bò" required>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="form-label small text-muted">Đơn giá</label>
                                <input type="number" name="price" class="form-control" placeholder="0" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label small text-muted">Đơn vị</label>
                                <select name="unit" class="form-select">
                                    <option value="Lon">Lon</option>
                                    <option value="Chai">Chai</option>
                                    <option value="Gói">Gói</option>
                                    <option value="Dĩa">Dĩa</option>
                                    <option value="Tô">Tô</option>
                                    <option value="Ly">Ly</option>
                                    <option value="Khác">Khác</option>
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-success w-100">Lưu lại</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editServiceModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sửa Dịch vụ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editServiceForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Tên dịch vụ</label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="form-label">Đơn giá</label>
                                <input type="number" name="price" id="edit_price" class="form-control" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Đơn vị</label>
                                <select name="unit" id="edit_unit" class="form-select">
                                    <option value="Lon">Lon</option>
                                    <option value="Chai">Chai</option>
                                    <option value="Gói">Gói</option>
                                    <option value="Dĩa">Dĩa</option>
                                    <option value="Tô">Tô</option>
                                    <option value="Ly">Ly</option>
                                    <option value="Khác">Khác</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

@section('script')
    <script>
        const services = @json($services->keyBy('id'))

        function openModalService(id) {
            const data = services[id]
            console.log(data);
            document.getElementById('editServiceForm').action = `/room/manage-services/update/${data.id}`;
            document.getElementById('edit_name').value = data.name;
            document.getElementById('edit_price').value = data.price;
            document.getElementById('edit_unit').value = data.unit;
            


            const modal = new bootstrap.Modal(document.getElementById('editServiceModal'));
            modal.show();
        }
    </script>
@endsection
