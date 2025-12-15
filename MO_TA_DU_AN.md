# Mô tả Tổng quan Dự án: Hệ thống Quản lý Khách sạn (Booking Web)

## 1. Tổng quan dự án (Project Overview)
**Booking Web** là một hệ thống phần mềm quản lý khách sạn trên nền tảng Web, được xây dựng để hỗ trợ các nghiệp vụ hàng ngày của lễ tân và quản lý khách sạn. Hệ thống cung cấp giao diện trực quan để theo dõi trạng thái phòng, quản lý đặt phòng, và tính toán chi phí dịch vụ một cách chính xác.

Dự án tập trung vào việc số hóa quy trình check-in, check-out, và quản lý hồ sơ khách hàng, giúp giảm thiểu sai sót so với việc quản lý sổ sách thủ công.

## 2. Mục đích của dự án (Project Purpose)
*   **Tối ưu hóa vận hành:** Giúp lễ tân thao tác nhanh chóng khi có khách đến nhận phòng hoặc trả phòng, kiểm tra tình trạng phòng trống ngay lập tức.
*   **Quản lý minh bạch:** Ghi lại chi tiết lịch sử đặt phòng, doanh thu, và các dịch vụ khách đã sử dụng.
*   **Chăm sóc khách hàng:** Lưu trữ thông tin khách hàng, phân loại khách VIP hoặc Blacklist để có chính sách phục vụ phù hợp.
*   **Kiểm soát tài chính:** Tự động tính tiền phòng theo các khung giờ (theo giờ, qua đêm, theo ngày) và các phụ phí đi kèm.

## 3. Các tính năng chính (Key Features)

### 3.1. Quản lý Phòng & Loại phòng (Room Management)
*   **Quản lý Loại phòng:** Định nghĩa các hạng phòng (Đơn, Đôi, VIP...) cùng với bảng giá linh hoạt (Giá giờ đầu, giá qua đêm, giá ngày).
*   **Quản lý Phòng:** Thêm/Sửa/Xóa phòng. Theo dõi trạng thái phòng thời gian thực:
    *   🟢 Sẵn sàng (Available)
    *   🔴 Có khách (Occupied)
    *   🧹 Đang dọn dẹp (Cleaning)
    *   🛠️ Đang bảo trì (Maintenance)
    *   🔒 Đã khóa (Disable)

### 3.2. Quản lý Đặt phòng (Booking System)
*   **Tạo Booking:** Hỗ trợ đặt phòng trực tiếp cho khách lẻ hoặc khách quen.
*   **Check-in / Check-out:** Quy trình nhận/trả phòng nhanh gọn.
*   **Tự động tính tiền:** Tính toán tiền phòng dựa trên thời gian lưu trú và bảng giá loại phòng. Hỗ trợ tính thêm tiền dịch vụ và phụ thu.

### 3.3. Dịch vụ & Hóa đơn (Services & Invoicing)
*   **Quản lý Dịch vụ:** Menu dịch vụ (Minibar, Giặt ủi, Ăn uống...).
*   **Order Dịch vụ:** Thêm dịch vụ vào phòng đang thuê.
*   **Thanh toán:** Xuất hóa đơn tổng hợp gồm tiền phòng và tiền dịch vụ.

### 3.4. Quản lý Khách hàng (Customer CRM)
*   **Hồ sơ khách hàng:** Lưu trữ CCCD, số điện thoại, quốc tịch.
*   **Phân hạng:** Khách thường, VIP, hoặc Blacklist (chặn đặt phòng).
*   **Lịch sử:** Xem lại các lần thuê trước đó.

### 3.5. Phân quyền (Role Management)
*   **Manager (Quản lý):** Toàn quyền cấu hình hệ thống, quản lý nhân viên, xem báo cáo doanh thu.
*   **Saler (Lễ tân):** Thực hiện các nghiệp vụ bán hàng, đặt phòng, chăm sóc khách hàng.

## 4. Công nghệ sử dụng (Technology Stack)
*   **Backend:** Laravel Framework (PHP 8.x) - Đảm bảo bảo mật và hiệu năng.
*   **Database:** MySQL - Lưu trữ dữ liệu an toàn.
*   **Frontend:** Blade Templates, Bootstrap 5 - Giao diện thân thiện, responsive.
*   **Scripting:** jQuery/AJAX - Xử lý các thao tác bất đồng bộ mượt mà (tìm kiếm khách hàng, load modal).

## 5. Trạng thái hiện tại
Dự án đã hoàn thiện các chức năng cốt lõi và đã được kiểm thử (Unit Testing & Manual Testing). Một số cải tiến đang được xem xét (như tìm kiếm khách hàng nâng cao).
