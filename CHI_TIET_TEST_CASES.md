# Tài liệu Test Case - Hệ thống Booking

Tài liệu này mô tả chi tiết các test case cho dự án Booking System, được định dạng theo mẫu yêu cầu.

## 1. Module Xác thực (Authentication)

### TC001: Đăng nhập thành công

| Mục | Nội dung |
|---|---|
| **Tên mô tả cho testcase** | Đăng nhập người dùng - Thành công |
| **Chức năng kiểm tra** | Quản lý Xác thực |
| **Giả định** | Tài khoản người dùng đã tồn tại |
| **Tên người viết testcase** | Antigravity |
| **Kỹ thuật test** | Trực tiếp trên chương trình |
| **Các bước thực hiện** | 1. Truy cập trang `/login`<br>2. Nhập email và mật khẩu hợp lệ<br>3. Nhấn nút Đăng nhập |
| **Kết quả mong đợi** | Người dùng được chuyển hướng đến trang dashboard/trang chủ. |
| **Kết quả thực tế** | |
| **Hướng giải quyết** | |

### TC002: Đăng nhập thất bại

| Mục | Nội dung |
|---|---|
| **Tên mô tả cho testcase** | Đăng nhập người dùng - Thất bại |
| **Chức năng kiểm tra** | Quản lý Xác thực |
| **Giả định** | Không có |
| **Tên người viết testcase** | Antigravity |
| **Kỹ thuật test** | Trực tiếp trên chương trình |
| **Các bước thực hiện** | 1. Truy cập trang `/login`<br>2. Nhập email hoặc mật khẩu không hợp lệ<br>3. Nhấn nút Đăng nhập |
| **Kết quả mong đợi** | Thông báo lỗi "Invalid login" hiển thị. Người dùng vẫn ở lại trang đăng nhập. |
| **Kết quả thực tế** | |
| **Hướng giải quyết** | |

### TC003: Đăng ký thành công

| Mục | Nội dung |
|---|---|
| **Tên mô tả cho testcase** | Đăng ký người dùng - Thành công |
| **Chức năng kiểm tra** | Quản lý Xác thực |
| **Giả định** | Không có |
| **Tên người viết testcase** | Antigravity |
| **Kỹ thuật test** | Trực tiếp trên chương trình |
| **Các bước thực hiện** | 1. Truy cập `/register`<br>2. Nhập chính xác Tên, Email, SĐT, Mật khẩu và Xác nhận mật khẩu<br>3. Nhấn nút Đăng ký |
| **Kết quả mong đợi** | Người dùng được chuyển hướng đến trang đăng nhập (hoặc tự động đăng nhập). |
| **Kết quả thực tế** | |
| **Hướng giải quyết** | |

### TC004: Đăng ký - Kiểm tra dữ liệu (Validation)

| Mục | Nội dung |
|---|---|
| **Tên mô tả cho testcase** | Đăng ký người dùng - Trùng email |
| **Chức năng kiểm tra** | Quản lý Xác thực |
| **Giả định** | Người dùng với email này đã tồn tại |
| **Tên người viết testcase** | Antigravity |
| **Kỹ thuật test** | Trực tiếp trên chương trình |
| **Các bước thực hiện** | 1. Truy cập `/register`<br>2. Nhập địa chỉ email đã tồn tại trong hệ thống<br>3. Nhấn nút Đăng ký |
| **Kết quả mong đợi** | Thông báo lỗi "The email has already been taken" được hiển thị. |
| **Kết quả thực tế** | |
| **Hướng giải quyết** | |

### TC005: Đăng xuất

| Mục | Nội dung |
|---|---|
| **Tên mô tả cho testcase** | Đăng xuất người dùng |
| **Chức năng kiểm tra** | Quản lý Xác thực |
| **Giả định** | Người dùng đang đăng nhập |
| **Tên người viết testcase** | Antigravity |
| **Kỹ thuật test** | Trực tiếp trên chương trình |
| **Các bước thực hiện** | 1. Nhấn nút/link Đăng xuất (Logout) |
| **Kết quả mong đợi** | Người dùng bị đăng xuất và chuyển hướng về trang đăng nhập với thông báo thành công. |
| **Kết quả thực tế** | |
| **Hướng giải quyết** | |

## 2. Quản lý Loại phòng (Room Type Management)

### TC006: Xem danh sách loại phòng

| Mục | Nội dung |
|---|---|
| **Tên mô tả cho testcase** | Xem danh sách loại phòng |
| **Chức năng kiểm tra** | Quản lý Loại phòng |
| **Giả định** | Người dùng (Admin/Manager) đang đăng nhập |
| **Tên người viết testcase** | Antigravity |
| **Kỹ thuật test** | Trực tiếp trên chương trình |
| **Các bước thực hiện** | 1. Truy cập `/room/manage-type-room` |
| **Kết quả mong đợi** | Danh sách các loại phòng hiện có được hiển thị. |
| **Kết quả thực tế** | |
| **Hướng giải quyết** | |

### TC007: Thêm loại phòng thành công

| Mục | Nội dung |
|---|---|
| **Tên mô tả cho testcase** | Thêm loại phòng - Thành công |
| **Chức năng kiểm tra** | Quản lý Loại phòng |
| **Giả định** | Người dùng đang đăng nhập |
| **Tên người viết testcase** | Antigravity |
| **Kỹ thuật test** | Trực tiếp trên chương trình |
| **Các bước thực hiện** | 1. Truy cập `/room/manage-type-room`<br>2. Điền Tên loại phòng, Giá, Mô tả<br>3. Gửi form (Lưu/Thêm) |
| **Kết quả mong đợi** | Loại phòng mới được thêm và hiển thị trong danh sách. |
| **Kết quả thực tế** | |
| **Hướng giải quyết** | |

### TC008: Cập nhật loại phòng

| Mục | Nội dung |
|---|---|
| **Tên mô tả cho testcase** | Cập nhật thông tin loại phòng |
| **Chức năng kiểm tra** | Quản lý Loại phòng |
| **Giả định** | Người dùng đang đăng nhập |
| **Tên người viết testcase** | Antigravity |
| **Kỹ thuật test** | Trực tiếp trên chương trình |
| **Các bước thực hiện** | 1. Chọn một loại phòng để sửa<br>2. Thay đổi Tên hoặc Giá<br>3. Gửi cập nhật |
| **Kết quả mong đợi** | Thông tin loại phòng được cập nhật thành công. |
| **Kết quả thực tế** | |
| **Hướng giải quyết** | |

### TC009: Lọc/Tìm kiếm loại phòng

| Mục | Nội dung |
|---|---|
| **Tên mô tả cho testcase** | Lọc danh sách loại phòng |
| **Chức năng kiểm tra** | Quản lý Loại phòng |
| **Giả định** | Người dùng đang đăng nhập |
| **Tên người viết testcase** | Antigravity |
| **Kỹ thuật test** | Trực tiếp trên chương trình |
| **Các bước thực hiện** | 1. Sử dụng form tìm kiếm trên trang `/room/manage-type-room`<br>2. Nhập tiêu chí tìm kiếm<br>3. Nhấn Tìm kiếm |
| **Kết quả mong đợi** | Danh sách chỉ hiển thị các loại phòng khớp với tiêu chí. |
| **Kết quả thực tế** | |
| **Hướng giải quyết** | |

## 3. Quản lý Phòng (Room Management)

### TC010: Xem danh sách phòng

| Mục | Nội dung |
|---|---|
| **Tên mô tả cho testcase** | Xem danh sách phòng |
| **Chức năng kiểm tra** | Quản lý Phòng |
| **Giả định** | Người dùng đang đăng nhập |
| **Tên người viết testcase** | Antigravity |
| **Kỹ thuật test** | Trực tiếp trên chương trình |
| **Các bước thực hiện** | 1. Truy cập `/room/manage-room` |
| **Kết quả mong đợi** | Danh sách các phòng được hiển thị cùng trạng thái và loại phòng. |
| **Kết quả thực tế** | |
| **Hướng giải quyết** | |

### TC011: Thêm phòng mới

| Mục | Nội dung |
|---|---|
| **Tên mô tả cho testcase** | Thêm phòng - Thành công |
| **Chức năng kiểm tra** | Quản lý Phòng |
| **Giả định** | Đã có ít nhất một Loại phòng trong hệ thống |
| **Tên người viết testcase** | Antigravity |
| **Kỹ thuật test** | Trực tiếp trên chương trình |
| **Các bước thực hiện** | 1. Truy cập `/room/manage-room`<br>2. Nhấn Thêm phòng<br>3. Nhập Tên/Số phòng, Chọn Loại phòng<br>4. Gửi form |
| **Kết quả mong đợi** | Phòng mới được tạo và xuất hiện trong danh sách. |
| **Kết quả thực tế** | |
| **Hướng giải quyết** | |

### TC012: Cập nhật phòng

| Mục | Nội dung |
|---|---|
| **Tên mô tả cho testcase** | Cập nhật thông tin phòng |
| **Chức năng kiểm tra** | Quản lý Phòng |
| **Giả định** | Người dùng đang đăng nhập |
| **Tên người viết testcase** | Antigravity |
| **Kỹ thuật test** | Trực tiếp trên chương trình |
| **Các bước thực hiện** | 1. Chọn một phòng để sửa<br>2. Thay đổi thông tin (VD: Trạng thái, Loại phòng)<br>3. Gửi form |
| **Kết quả mong đợi** | Thông tin phòng được cập nhật. |
| **Kết quả thực tế** | |
| **Hướng giải quyết** | |

## 4. Quản lý Dịch vụ (Service Management)

### TC014: Xem danh sách dịch vụ

| Mục | Nội dung |
|---|---|
| **Tên mô tả cho testcase** | Xem danh sách dịch vụ |
| **Chức năng kiểm tra** | Quản lý Dịch vụ |
| **Giả định** | Người dùng đang đăng nhập |
| **Tên người viết testcase** | Antigravity |
| **Kỹ thuật test** | Trực tiếp trên chương trình |
| **Các bước thực hiện** | 1. Truy cập `/room/manage-services` |
| **Kết quả mong đợi** | Danh sách các dịch vụ khả dụng được hiển thị. |
| **Kết quả thực tế** | |
| **Hướng giải quyết** | |

### TC015: Thêm dịch vụ

| Mục | Nội dung |
|---|---|
| **Tên mô tả cho testcase** | Thêm dịch vụ mới |
| **Chức năng kiểm tra** | Quản lý Dịch vụ |
| **Giả định** | Người dùng đang đăng nhập |
| **Tên người viết testcase** | Antigravity |
| **Kỹ thuật test** | Trực tiếp trên chương trình |
| **Các bước thực hiện** | 1. Nhập Tên dịch vụ và Giá<br>2. Gửi form |
| **Kết quả mong đợi** | Dịch vụ mới được thêm vào hệ thống. |
| **Kết quả thực tế** | |
| **Hướng giải quyết** | |

### TC017: Xóa dịch vụ

| Mục | Nội dung |
|---|---|
| **Tên mô tả cho testcase** | Xóa dịch vụ |
| **Chức năng kiểm tra** | Quản lý Dịch vụ |
| **Giả định** | Người dùng đang đăng nhập |
| **Tên người viết testcase** | Antigravity |
| **Kỹ thuật test** | Trực tiếp trên chương trình |
| **Các bước thực hiện** | 1. Nhấn Xóa trên một dịch vụ |
| **Kết quả mong đợi** | Dịch vụ bị xóa khỏi danh sách. |
| **Kết quả thực tế** | |
| **Hướng giải quyết** | |

## 5. Quản lý Khách hàng (Customer Management)

### TC018: Xem danh sách khách hàng

| Mục | Nội dung |
|---|---|
| **Tên mô tả cho testcase** | Xem danh sách khách hàng |
| **Chức năng kiểm tra** | Quản lý Khách hàng |
| **Giả định** | Người dùng đang đăng nhập |
| **Tên người viết testcase** | Antigravity |
| **Kỹ thuật test** | Trực tiếp trên chương trình |
| **Các bước thực hiện** | 1. Truy cập `/customer/manage-customer` |
| **Kết quả mong đợi** | Danh sách khách hàng được hiển thị. |
| **Kết quả thực tế** | |
| **Hướng giải quyết** | |

### TC019: Tìm kiếm khách hàng

| Mục | Nội dung |
|---|---|
| **Tên mô tả cho testcase** | Lọc/Tìm kiếm khách hàng |
| **Chức năng kiểm tra** | Quản lý Khách hàng |
| **Giả định** | Người dùng đang đăng nhập |
| **Tên người viết testcase** | Antigravity |
| **Kỹ thuật test** | Trực tiếp trên chương trình |
| **Các bước thực hiện** | 1. Tìm kiếm khách hàng bằng tên hoặc số điện thoại<br>2. Nhấn Tìm kiếm |
| **Kết quả mong đợi** | Hồ sơ khách hàng chính xác được hiển thị. |
| **Kết quả thực tế** | |
| **Hướng giải quyết** | |

## 6. Đặt phòng (Booking & Reservation)

### TC020: Xem danh sách đặt phòng

| Mục | Nội dung |
|---|---|
| **Tên mô tả cho testcase** | Xem danh sách booking |
| **Chức năng kiểm tra** | Quản lý Đặt phòng |
| **Giả định** | Người dùng đang đăng nhập |
| **Tên người viết testcase** | Antigravity |
| **Kỹ thuật test** | Trực tiếp trên chương trình |
| **Các bước thực hiện** | 1. Truy cập `/booking/manage-booking` |
| **Kết quả mong đợi** | Danh sách tất cả các booking được hiển thị. |
| **Kết quả thực tế** | |
| **Hướng giải quyết** | |

### TC021: Tạo đặt phòng (Reservation)

| Mục | Nội dung |
|---|---|
| **Tên mô tả cho testcase** | Tạo đặt phòng mới |
| **Chức năng kiểm tra** | Quản lý Đặt phòng |
| **Giả định** | Có phòng trống |
| **Tên người viết testcase** | Antigravity |
| **Kỹ thuật test** | Trực tiếp trên chương trình |
| **Các bước thực hiện** | 1. Truy cập `/reserve/reserves`<br>2. Chọn Phòng, Khách hàng, Ngày tháng<br>3. Xác nhận đặt phòng |
| **Kết quả mong đợi** | Booking được tạo và trạng thái phòng được cập nhật. |
| **Kết quả thực tế** | |
| **Hướng giải quyết** | |

### TC022: Cập nhật dịch vụ cho Booking

| Mục | Nội dung |
|---|---|
| **Tên mô tả cho testcase** | Cập nhật dịch vụ Booking |
| **Chức năng kiểm tra** | Quản lý Đặt phòng |
| **Giả định** | Booking đã tồn tại |
| **Tên người viết testcase** | Antigravity |
| **Kỹ thuật test** | Trực tiếp trên chương trình |
| **Các bước thực hiện** | 1. Chọn một booking<br>2. Thêm/Cập nhật các dịch vụ đã sử dụng<br>3. Lưu lại |
| **Kết quả mong đợi** | Tổng tiền booking được cập nhật phản ánh phí dịch vụ. |
| **Kết quả thực tế** | |
| **Hướng giải quyết** | |

## 7. Bảo mật (Security)

### TC023: Truy cập không xác thực

| Mục | Nội dung |
|---|---|
| **Tên mô tả cho testcase** | Truy cập trang quản trị khi chưa đăng nhập |
| **Chức năng kiểm tra** | Bảo mật |
| **Giả định** | Người dùng CHƯA đăng nhập |
| **Tên người viết testcase** | Antigravity |
| **Kỹ thuật test** | Trực tiếp trên chương trình |
| **Các bước thực hiện** | 1. Cố gắng truy cập `/room/manage-room` |
| **Kết quả mong đợi** | Người dùng bị chuyển hướng về `/login`. |
| **Kết quả thực tế** | |
| **Hướng giải quyết** | |
