# Lộ Trình Phát Triển Dự Án (Development Roadmap)

Để hoàn thiện dự án **Booking Web** và đưa vào vận hành thực tế, dưới đây là kế hoạch phát triển chia làm 4 Sprints (mỗi Sprint dự kiến 1-2 tuần).

## Sprint 1: Khắc phục lỗi & Củng cố Core Logic (Fix & Core)
**Mục tiêu:** Đảm bảo các chức năng cơ bản hoạt động chính xác 100%, không còn lỗi logic.

*   **1.1. Sửa lỗi tính giá Booking (TC022):**
    *   Cập nhật lại logic: Khi thêm/sửa dịch vụ trong booking, hệ thống phải tự động tính lại tổng tiền (`total_price`) và cập nhật ngay vào database.
    *   Hiển thị giá tạm tính ngay trên giao diện modal.
*   **1.2. Nâng cấp tìm kiếm Khách hàng (TC019):**
    *   Sửa lại bộ lọc (`Model Scope`) để hỗ trợ tìm kiếm theo cả Tên và Số điện thoại (hiện tại chỉ tìm theo SĐT).
    *   Cải thiện UX ô tìm kiếm (Live search hoặc Auto-complete).
*   **1.3. Rà soát Validation:**
    *   Kiểm tra kỹ các form nhập liệu (Booking, Room, Service).
    *   Đảm bảo thông báo lỗi hiển thị bằng tiếng Việt rõ ràng, thân thiện.

## Sprint 2: Nâng cao trải nghiệm người dùng & CRM (UX & CRM)
**Mục tiêu:** Giúp lễ tân thao tác nhanh hơn và quản lý khách hàng hiệu quả hơn.

*   **2.1. Quản lý Khách hàng nâng cao:**
    *   Hiển thị lịch sử đặt phòng chi tiết trong hồ sơ khách hàng (Ngày ở, Tổng tiền, Đánh giá).
    *   Tự động gợi ý hạng khách (VIP) dựa trên tổng chi tiêu.
*   **2.2. Cải tiến giao diện Booking:**
    *   Sử dụng Calendar View (Lịch) để nhìn trực quan phòng trống/đã đặt trong tháng.
    *   Kéo thả (Drag & Drop) để đổi phòng nhanh cho khách.
*   **2.3. Tối ưu thông báo:**
    *   Thêm thông báo (Toast notification) khi thao tác thành công/thất bại (đẹp mắt hơn alert mặc định).

## Sprint 3: Báo cáo thống kê & Quản trị (Reports & Admin)
**Mục tiêu:** Cung cấp cái nhìn tổng quan về tình hình kinh doanh cho Quản lý.

*   **3.1. Dashboard quản trị:**
    *   Biểu đồ doanh thu theo Ngày/Tuần/Tháng (sử dụng Chart.js).
    *   Thống kê công suất phòng (Occupancy Rate).
    *   Top dịch vụ bán chạy nhất.
*   **3.2. Xuất dữ liệu:**
    *   Tính năng xuất danh sách hóa đơn, khách hàng ra file Excel (.xlsx).
    *   In hóa đơn thanh toán trực tiếp từ trình duyệt (Print view).
*   **3.3. Phân quyền chi tiết hơn:**
    *   Kiểm soát chặt chẽ quyền xóa dữ liệu (chỉ Admin được xóa, Nhân viên chỉ được ẩn/khóa).

## Sprint 4: Bảo mật, Tối ưu & Bàn giao (Security & Deploy)
**Mục tiêu:** Đảm bảo hệ thống an toàn, nhanh chóng và sẵn sàng deploy.

*   **4.1. Bảo mật:**
    *   Chống Spam/Brute-force login (Rate Limiting).
    *   Log lại toàn bộ các hành động quan trọng (Ai đã xóa booking? Ai đã giảm giá?).
*   **4.2. Tối ưu hiệu năng:**
    *   Cache các dữ liệu ít thay đổi (Loại phòng, Dịch vụ).
    *   Tối ưu query database để load trang danh sách nhanh hơn.
*   **4.3. Đóng gói & Tài liệu:**
    *   Viết tài liệu hướng dẫn sử dụng (User Guide) cho lễ tân.
    *   Thiết lập quy trình Backup dữ liệu tự động (Database Backup).
    *   Deploy lên server chính thức.
