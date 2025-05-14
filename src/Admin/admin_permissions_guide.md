# 🛡️ Hệ Thống Phân Quyền Theo Vai Trò – Hướng Dẫn Quản Trị Viên

## 📌 Tổng Quan

Tài liệu này cung cấp thông tin chi tiết về cách quản lý hệ thống phân quyền theo vai trò (RBAC) trong ứng dụng thương mại điện tử. Hệ thống sẽ tự động gán các quyền phù hợp cho từng vai trò, không cần phân quyền thủ công.

## 👥 Các Vai Trò Người Dùng

Hệ thống hiện có 4 vai trò chính:

### 1. **Quản trị viên** (`vaitro_id = 1`)

- Toàn quyền truy cập tất cả các chức năng của hệ thống
- Quản lý người dùng, vai trò, phân quyền
- Truy cập tất cả trang quản trị

### 2. **Người dùng thông thường** (`vaitro_id = 2`)

- Vai trò mặc định cho khách hàng
- Không có quyền truy cập trang quản trị
- Có thể:
  - Xem sản phẩm
  - Đặt hàng
  - Quản lý thông tin tài khoản

### 3. **Nhân viên** (`vaitro_id = 3`)

- Vai trò hỗ trợ khách hàng & quản lý sản phẩm
- Có quyền truy cập quản trị giới hạn
- Có thể:
  - Quản lý danh mục, sản phẩm
  - Quản lý đơn hàng, bình luận
  - Quản lý màu sắc, phiếu bảo hành và đổi/trả

### 4. **Nhân viên kho** (`vaitro_id = 4`)

- Vai trò quản lý kho & nhà cung cấp
- Có thể:
  - Quản lý sản phẩm (chỉ đọc)
  - Quản lý nhà cung cấp
  - Quản lý phiếu nhập

---

## 🔐 Chi Tiết Quyền Hạn Theo Vai Trò

### ✅ Quản trị viên (`vaitro_id = 1`)

- Có toàn bộ các quyền (Q1 → Q15)
- Truy cập toàn bộ hệ thống

### 🛠️ Nhân viên (`vaitro_id = 3`)

- Q1: Truy cập quản lý
- Q2: Quản lý danh mục
- Q3: Quản lý sản phẩm
- Q5: Quản lý bình luận
- Q7: Quản lý đơn hàng
- Q9: Quản lý màu
- Q12: Quản lý phiếu bảo hành
- Q13: Quản lý phiếu đổi/trả

### 📦 Nhân viên kho (`vaitro_id = 4`)

- Q1: Truy cập quản lý
- Q3: Quản lý sản phẩm (chỉ xem)
- Q8: Quản lý nhà cung cấp
- Q11: Quản lý phiếu nhập

---

## 👨‍💼 Quản Lý Người Dùng & Vai Trò

### 👉 Gán Vai Trò Cho Người Dùng

1. Truy cập phần **Quản lý người dùng**
2. Chỉnh sửa tài khoản người dùng
3. Chọn vai trò phù hợp từ danh sách
4. Lưu thay đổi

### ➕ Khi Tạo Người Dùng Mới

Hệ thống sẽ tự động:

- Gán vai trò được chọn
- Cấp quyền tương ứng với vai trò đó
- Không cần gán quyền thủ công

---

## ⚠️ Lưu Ý Bảo Mật & Hoạt Động

1. **Gán quyền tự động**

   - Các quyền sẽ được gán dựa trên vai trò
   - Đảm bảo sự nhất quán trong hệ thống

2. **Giới hạn đăng nhập**

   - Tài khoản Admin và Nhân viên: đăng nhập qua trang quản trị
   - Người dùng thông thường: đăng nhập qua trang khách hàng
   - Hệ thống tự động từ chối đăng nhập sai vai trò

3. **Khuyến nghị bảo mật**
   - Gán vai trò thấp nhất có thể cho từng người dùng
   - Xem lại vai trò định kỳ
   - Ưu tiên dùng vai trò **Nhân viên** thay vì **Quản trị viên** nếu không thật sự cần

---

📄 _Tài liệu được dịch và biên soạn lại từ hướng dẫn hệ thống RBAC của ứng dụng thương mại điện tử._
