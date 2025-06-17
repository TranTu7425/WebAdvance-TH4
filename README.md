# 👗 Phenikaa Fashion Shop - Thời Trang Sành Điệu

## Thành viên dự án
- **Trần Anh Tú:** 23010332

## Truy cập dự án
- **Public Link:** [Đang cập nhật]
- **Demo Link:** [Đang cập nhật]

## Mô tả
`Phenikaa Fashion Shop` là một ứng dụng web thương mại điện tử chuyên về thời trang, được xây dựng trên Laravel Framework. Website cung cấp giao diện thân thiện với người dùng, tích hợp đầy đủ các tính năng cần thiết cho một hệ thống thương mại điện tử hiện đại.

## 📦 Tính năng chính
- **Xác thực người dùng**
  - Đăng ký tài khoản
  - Đăng nhập/Đăng xuất
  - Quản lý thông tin cá nhân
  - Quản lý địa chỉ giao hàng

- **Quản lý sản phẩm**
  - Hiển thị danh sách sản phẩm theo danh mục
  - Tìm kiếm và lọc sản phẩm
  - Chi tiết sản phẩm với hình ảnh
  - Quản lý thương hiệu (Brands)
  - Quản lý danh mục (Categories)

- **Giỏ hàng & Thanh toán**
  - Thêm/Xóa sản phẩm vào giỏ
  - Cập nhật số lượng sản phẩm
  - Áp dụng mã giảm giá
  - Thanh toán an toàn
  - Quản lý địa chỉ giao hàng

- **Quản lý đơn hàng**
  - Theo dõi trạng thái đơn hàng
  - Lịch sử đơn hàng
  - Xuất hóa đơn
  - Quản lý giao hàng

- **Trang quản trị**
  - Dashboard thống kê doanh thu
  - Quản lý sản phẩm và tồn kho
  - Quản lý đơn hàng và trạng thái
  - Quản lý người dùng
  - Quản lý mã giảm giá
  - Quản lý slider trang chủ
  - Quản lý liên hệ
  - Cài đặt hệ thống

## 🚀 Yêu cầu hệ thống
- PHP >= 8.1
- Composer
- MySQL >= 5.7
- Node.js >= 16.x
- NPM >= 8.x

## 🔧 Hướng dẫn cài đặt
```bash
# Clone repository
git clone [repository-url]
cd phenikaa-fashion-shop

# Cài đặt dependencies
composer install
npm install

# Cấu hình môi trường
cp .env.example .env
php artisan key:generate

# Cấu hình database trong file .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=phenikaa_fashion
DB_USERNAME=root
DB_PASSWORD=

# Chạy migrations và seeders
php artisan migrate --seed

# Build assets
npm run build

# Khởi chạy server
php artisan serve
```

## 📱 Công nghệ sử dụng
- **Backend:** Laravel 10.x
- **Frontend:** 
  - Blade Templates
  - TailwindCSS
  - Alpine.js
- **Database:** MySQL
- **Công cụ phát triển:**
  - Git
  - Composer
  - NPM

## 🤝 Đóng góp
Mọi đóng góp đều được hoan nghênh! Vui lòng thực hiện theo các bước sau:
1. Fork repository
2. Tạo branch mới (`git checkout -b feature/AmazingFeature`)
3. Commit thay đổi (`git commit -m 'Add some AmazingFeature'`)
4. Push lên branch (`git push origin feature/AmazingFeature`)
5. Tạo Pull Request

## 📄 Giấy phép
Dự án này được cấp phép theo [MIT License](LICENSE).

---
*Phenikaa Fashion Shop* - Thời trang sành điệu, phong cách riêng bạn!

