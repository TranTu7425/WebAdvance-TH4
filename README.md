# 🍂 Quế VĂN YÊN - Website Bán Sản Phẩm Quế

## Thành viên dự án
- **Trần Anh Tú:** 23010332

## Mô tả
`Quế VĂN YÊN` là một ứng dụng web thương mại điện tử chuyên bán các sản phẩm từ quế cao cấp, được xây dựng trên Laravel Framework và PHP. Website cung cấp giao diện thân thiện, tính năng quản lý sản phẩm, giỏ hàng và thanh toán bảo mật.

## 📦 Tính năng
- **Đăng ký / Đăng nhập**: Hệ thống xác thực người dùng (Laravel Auth).
- **Quản lý sản phẩm**: Thêm, sửa, xóa sản phẩm quế với hình ảnh, giá cả, mô tả chi tiết.
- **Duyệt danh mục**: Phân loại sản phẩm theo loại quế, nguồn gốc.
- **Giỏ hàng & Thanh toán**: Thêm sản phẩm vào giỏ, cập nhật số lượng, xử lý thanh toán qua cổng (ví dụ: Stripe, PayPal).
- **Đơn hàng**: Xem lịch sử đơn hàng, trạng thái (chờ xử lý, đã giao).
- **Liên hệ & Bình luận**: Form liên hệ, gửi phản hồi; người dùng có thể bình luận về sản phẩm.
- **Dashboard Admin**: Thống kê doanh thu, quản lý đơn hàng, quản lý người dùng.

## 🚀 Yêu cầu cài đặt
- PHP >= 8.0
- Composer
- MySQL hoặc MariaDB
- Node.js & NPM (cho frontend assets)

## 🔧 Cài đặt & Chạy dự án
```bash
# Clone repository
git clone https://github.com/username/que-vn.git
cd que-vn

# Cài đặt dependencies PHP
composer install

# Cài đặt dependencies frontend
npm install
npm run dev

# Tạo file .env và cấu hình database\cp .env.example .env
php artisan key:generate
# Mở .env, cập nhật DB_DATABASE, DB_USERNAME, DB_PASSWORD

# Chạy migrate & seed data (nếu có)
php artisan migrate --seed

# Chạy server local
php artisan serve
# Mở trình duyệt tại http://127.0.0.1:8000
```

## 🔑 Sử dụng
1. Đăng ký tài khoản hoặc đăng nhập.
2. Duyệt sản phẩm quế, thêm vào giỏ hàng.
3. Vào trang Giỏ hàng để điều chỉnh và thanh toán.
4. Theo dõi đơn hàng và trạng thái giao hàng tại mục `Đơn hàng của tôi`.

## 🤝 Đóng góp
Chúng tôi rất hoan nghênh các đóng góp từ cộng đồng:
1. Fork repository này.
2. Tạo branch feature: `git checkout -b feature/TenTuyChon`.
3. Commit thay đổi: `git commit -m 'Add some feature'`.
4. Đẩy lên branch: `git push origin feature/TenTuyChon`.
5. Tạo Pull Request.

## 📄 Giấy phép
Dự án này được cấp phép theo [MIT License](LICENSE).

---
*Quế Văn Yên* - Khát vọng vươn xa!

