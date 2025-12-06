    {{-- 1. Nhận dữ liệu từ bên ngoài truyền vào --}}
    @props(['room'])

    @php
        // 2. MAPPING PATTERN (Cấu hình giao diện)
        // Đây là nơi duy nhất bạn cần sửa nếu muốn đổi màu sắc sau này.
        $configs = [
            'available' => [
                'color' => 'success', // Xanh lá
                'bg' => 'white',
                'icon' => 'check-circle',
                'label' => 'Sẵn sàng',
            ],
            'booked' => [
                'color' => 'primary', // Xanh dương đậm
                'bg' => 'primary bg-opacity-10',
                'icon' => 'calendar-check',
                'label' => 'Đặt trước',
            ],
            'occupied' => [
                'color' => 'danger', // Đỏ
                'bg' => 'danger bg-opacity-10',
                'icon' => 'user-lock',
                'label' => 'Đang ở',
            ],
            'cleaning' => [
                'color' => 'warning', // Vàng
                'bg' => 'warning bg-opacity-10',
                'icon' => 'broom',
                'label' => 'Đang dọn',
            ],
            'maintenance' => [
                'color' => 'dark', // Đen/Xám đậm
                'bg' => 'secondary bg-opacity-25',
                'icon' => 'tools',
                'label' => 'Bảo trì',
            ],
            'disable' => [
                'color' => 'secondary', // Xám
                'bg' => 'secondary bg-opacity-50',
                'icon' => 'ban',
                'label' => 'Vô hiệu',
            ],
        ];

        // Lấy status của phòng. Nếu status trong DB không khớp config thì fallback về 'disable'
        $status = $room->status;
        $theme = $configs[$status] ?? $configs['disable'];

        // Lấy booking & customer (đã load từ Controller) để dùng cho Header
        $booking = $room->activeBooking;
        $customer = $booking?->customer;
    @endphp

    {{-- 3. HTML SHELL (Khung hiển thị) --}}
    {{-- Thêm data attributes để Javascript tìm kiếm/lọc hoạt động --}}
    <div class="col-xl-3 col-lg-4 col-md-6 room-item" data-room="{{ $room->room_number }}"
        data-type="{{ $room->roomType->name ?? '' }}" data-status="{{ $status }}"
        data-floor="{{ $room->floor ?? 1 }}">

        {{-- Card chính: Class động dựa trên $theme['color'] và $theme['bg'] --}}
        <div
            class="card h-100 shadow-sm border-0 border-top border-4 border-{{ $theme['color'] }} bg-{{ $theme['bg'] }}">

            <div class="card-body position-relative p-3">

                {{-- A. HEADER CARD: Số phòng & Thông tin tóm tắt --}}
                <div class="d-flex align-items-center mb-3">
                    <!-- Khối hiển thị số phòng -->
                    <div class="bg-{{ $theme['color'] }} text-white rounded-3 d-flex align-items-center justify-content-center me-3 shadow-sm"
                        style="width: 50px; height: 50px; min-width: 50px;">
                        <span class="h4 mb-0 fw-bold">{{ $room->room_number }}</span>
                    </div>

                    <!-- Tên trạng thái hoặc Tên khách (Logic hiển thị thông minh) -->
                    <div class="text-truncate overflow-hidden">
                        <h6 class="mb-0 fw-bold text-{{ $theme['color'] }} text-truncate">
                            @if (($status === 'occupied' || $status === 'booked') && $customer)
                                {{-- Nếu đang ở/đặt trước thì hiện tên khách --}}
                                {{ $customer->name }}
                            @else
                                {{-- Còn lại hiện Label trạng thái --}}
                                {{ $theme['label'] }}
                            @endif
                        </h6>
                        <small class="text-muted d-block text-truncate">
                            {{ $room->roomType->name ?? 'Phòng tiêu chuẩn' }}
                        </small>
                    </div>
                </div>

                {{-- B. MENU NGỮ CẢNH (Context Menu - 3 chấm) --}}
                <div class="dropdown position-absolute top-0 end-0 mt-2 me-2">
                    <button class="btn btn-sm btn-link text-secondary p-0" data-bs-toggle="dropdown">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <li>
                            <h6 class="dropdown-header">Thao tác nhanh</h6>
                        </li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-info-circle me-2 text-info"></i>Xem
                                chi
                                tiết</a></li>
                        <li><a class="dropdown-item" href="#"><i
                                    class="fas fa-history me-2 text-secondary"></i>Lịch
                                sử phòng</a></li>
                        {{-- Bạn có thể thêm các menu dynamic theo status ở đây nếu muốn --}}
                    </ul>
                </div>

                {{-- C. NỘI DUNG ĐỘNG (Dynamic Content Area) --}}
                {{-- Đây là phần quan trọng nhất: Load file view con dựa trên tên status --}}
                <div class="room-action-area mt-2">
                    @includeIf("components.room-partials.{$status}", ['room' => $room])
                </div>

            </div>
        </div>
    </div>
