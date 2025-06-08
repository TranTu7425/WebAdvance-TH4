@extends('layouts.app')
@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
      <h2 class="page-title">My Account</h2>
      <div class="row">
        <div class="col-lg-3">
          @include('user.account-nav')
        </div>
        <div class="col-lg-9">
          <div class="page-content my-account__dashboard">
            <p>Xin chào <strong>User</strong></p>
            <p>Từ bảng điều khiển của bạn, bạn có thể xem <a class="unerline-link" href="account_orders.html">đơn hàng gần đây</a>, quản lý <a class="unerline-link" href="account_edit_address.html">địa chỉ giao hàng</a>, và <a class="unerline-link" href="account_edit.html">chỉnh sửa thông tin tài khoản và mật khẩu</a>.</p>
          </div>
        </div>
      </div>
    </section>
  </main>
@endsection