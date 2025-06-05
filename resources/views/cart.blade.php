@extends('layouts.app')

@section('content')
<style>
  .text-success {
    color:rgb(0, 105, 56);
  }
  .text-danger {
    color: #dc3545;
  }
</style>
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">
      <h2 class="page-title">Giỏ hàng</h2>
      <div class="checkout-steps">
        <a href="javascript:void(0)" class="checkout-steps__item active">
          <span class="checkout-steps__item-number">01</span>
          <span class="checkout-steps__item-title">
            <span>Giỏ hàng</span>
            <em>Quản lý danh sách sản phẩm</em>
          </span>
        </a>
        <a href="javascript:void(0)" class="checkout-steps__item">
          <span class="checkout-steps__item-number">02</span>
          <span class="checkout-steps__item-title">
            <span>Vận chuyển và thanh toán</span>
            <em>Thanh toán sản phẩm</em>
          </span>
        </a>
        <a href="javascript:void(0)" class="checkout-steps__item">
          <span class="checkout-steps__item-number">03</span>
          <span class="checkout-steps__item-title">
            <span>Xác nhận</span>
            <em>Xem lại và gửi đơn hàng</em>
          </span>
        </a>
      </div>
      <div class="shopping-cart">
        @if($items->count() > 0)
        <div class="cart-table__wrapper">
          <table class="cart-table">
            <thead>
              <tr>
                <th>Sản phẩm</th>
                <th></th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Tổng phụ</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach($items as $item)
              <tr>
                <td>
                  <div class="shopping-cart__product-item">
                    <img loading="lazy" src="{{ asset('uploads/products/thumbnails') }}/{{ $item->model->image }}" width="120" height="120" alt="" />
                  </div>
                </td>
                <td>
                  <div class="shopping-cart__product-item__detail">
                    <h4>{{ $item->name }}</h4>
                    <ul class="shopping-cart__product-item__options">
                      <li>Màu sắc: Vàng</li>
                      <li>Kích thước: L</li>
                    </ul>
                  </div>
                </td>
                <td>
                  <span class="shopping-cart__product-price">${{ $item->price }}</span>
                </td>
                <td>
                  <div class="qty-control position-relative">
                    <input type="number" name="quantity" value="{{ $item->qty }}" min="1" class="qty-control__number text-center">
                    <form method="POST" action="{{ route('cart.qty.decrease', ['rowId' => $item->rowId]) }}">
                      @csrf
                      @method('PUT')
                      <div class="qty-control__reduce">-</div>
                    </form>

                    <form method="POST" action="{{ route('cart.qty.increase', ['rowId' => $item->rowId]) }}">
                      @csrf
                      @method('PUT')
                      <div class="qty-control__increase">+</div>
                    </form>
                  </div>
                </td>
                <td>
                  <span class="shopping-cart__subtotal">${{ $item->subTotal() }}</span>
                </td>
                <td>
                  <form method="POST" action="{{ route('cart.remove.item', ['rowId' => $item->rowId]) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="remove-cart">
                        <svg width="10" height="10" viewBox="0 0 10 10" fill="#767676" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                            <path d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                        </svg>
                    </button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <div class="cart-table-footer">
            @if(!Session::has('coupon'))
            <form action="{{ route('cart.apply.coupon') }}" method="POST" class="position-relative bg-body">
              @csrf
              <input class="form-control" type="text" name="coupon_code" placeholder="Mã giảm giá" value="">
              <input class="btn-link fw-medium position-absolute top-0 end-0 h-100 px-4" type="submit" value="ÁP DỤNG MÃ">
            </form>
            @else
            <form action="{{ route('cart.remove.coupon') }}" method="POST" class="position-relative bg-body">
              @csrf
              <input class="form-control" type="text" name="coupon_code" placeholder="Mã giảm giá" value="{{ Session::get('coupon')['code'] }} Đã áp dụng!" readonly>
              <input class="btn-link fw-medium position-absolute top-0 end-0 h-100 px-4" type="submit" value="XÓA MÃ">
            </form>
            @endif
            <form method="POST" action="{{ route('cart.clear') }}">
              @csrf
              @method('DELETE')
              <button class="btn btn-light" type="submit">XÓA GIỎ HÀNG</button>
            </form>
          </div>
          <div>
            @if(Session::has('success'))
              <p class="text-success">{{ Session::get('success') }}</p>
            @elseif(Session::has('error'))
              <p class="text-danger">{{ Session::get('error') }}</p>
            @endif
          </div>
        </div>
        <div class="shopping-cart__totals-wrapper">
          <div class="sticky-content">
            <div class="shopping-cart__totals">
              <h3>Tổng giỏ hàng</h3>
              @if(Session::has('discounts'))
              <table class="cart-totals">
                <tbody>
                  <tr>
                    <th>Tổng phụ</th>
                    <td>{{Cart::instance('cart')->subTotal()}}</td>
                  </tr>
                  <tr>
                    <th>Giảm giá {{Session::get('coupon')['code']}}</th>
                    <td>{{Session::get('discounts')['discount']}}</td>
                  </tr>
                  <tr>
                    <th>Tổng sau giảm giá</th>
                    <td>{{Session::get('discounts')['subtotal']}}</td>
                  </tr>
                  <tr>
                    <th>Phí vận chuyển</th>
                    <td>
                      Miễn phí
                    </td>
                  </tr>
                  <tr>
                    <th>Thuế VAT</th>
                    <td>
                      {{Session::get('discounts')['tax']}}
                    </td>
                  </tr>
                  <tr>
                    <th>Tổng cộng</th>
                    <td>
                      {{Session::get('discounts')['total']}}
                    </td>
                  </tr>
                </tbody>
              </table>
              @else
              <table class="cart-totals">
                <tbody>
                  <tr>
                    <th>Tổng phụ</th>
                    <td>{{Cart::instance('cart')->subTotal()}}</td>
                  </tr>
                  <tr>
                    <th>Phí vận chuyển</th>
                    <td>
                      Miễn phí
                    </td>
                  </tr>
                  <tr>
                    <th>Thuế VAT</th>
                    <td>
                      {{Cart::instance('cart')->tax()}}
                    </td>
                  </tr>
                  <tr>
                    <th>Tổng cộng</th>
                    <td>
                      {{Cart::instance('cart')->total()}}
                    </td>
                  </tr>
                </tbody>
              </table>
              @endif
            </div>
            <div class="mobile_fixed-btn_wrapper">
              <div class="button-wrapper container">
                <a href="{{ route('cart.checkout') }}" class="btn btn-primary btn-checkout">TIẾN HÀNH THANH TOÁN</a>
              </div>
            </div>
          </div>
        </div>
        @else
            <div class="row">
                <div class="col-md-12 text-center pt-5 bp-5>
                    <p>Không có sản phẩm nào trong giỏ hàng</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-info">Tiếp tục mua sắm</a>
                </div>
            </div>
        @endif
      </div>
    </section>
  </main>
@endsection

@push('scripts')
<script>
$(function(){
    $('.qty-control__increase').on("click", function(){
        $(this).closest('form').submit();
    });

    $('.qty-control__reduce').on("click", function(){
        $(this).closest('form').submit();
    });

    $('.remove-cart').on("click", function(){
        $(this).closest('form').submit();
    });

    // Cập nhật giá khi thay đổi số lượng
    $('.qty-control__number').on('change', function() {
        var form = $(this).closest('form');
        var rowId = form.find('input[name="rowId"]').val();
        var qty = $(this).val();
        
        $.ajax({
            url: '/cart/update-quantity/' + rowId,
            method: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                quantity: qty
            },
            success: function(response) {
                location.reload();
            }
        });
    });
});
</script>
@endpush


