@extends('layouts.app')

@section('content')

<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">
      <h2 class="page-title">Danh sách yêu thích</h2>
      <div class="shopping-cart">
        @if(Cart::instance('wishlist')->content()->count() > 0)
        <div class="cart-table__wrapper">
          <table class="cart-table">
            <thead>
              <tr>
                <th>Sản phẩm</th>
                <th></th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Thao tác</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
              <tr>
                <td>
                  <div class="shopping-cart__product-item">
                    <img loading="lazy" src="{{ asset('uploads/products/thumbnails/' . $item->model->image) }}" width="120" height="120" alt="{{$item->name}}" />
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
                  <span class="shopping-cart__product-price">{{ number_format($item->price) }}đ</span>
                </td>
                <td>
                  {{ $item->qty }}
                </td>
                
                <td>
                    <div class="row">
                        <div class="col-md-6">
                            <form action="{{ route('wishlist.move.to.cart', ['rowId' => $item->rowId]) }}" method="POST" id="move-to-cart-form-{{ $item->id }}">
                            @csrf
                            @method('POST')
                                <button type="submit" class="btn btn-sm btn-warning">Chuyển vào giỏ hàng</button>
                    </form>
                    </div>
                    <div class="col-md-6">
                        <form action="{{ route('wishlist.remove.item', ['rowId' => $item->rowId]) }}" method="POST" id="remove-item-form-{{ $item->id }}">
                            @csrf
                            @method('DELETE')
                  <a href="javascript:void(0)" class="remove-cart" onclick="document.getElementById('remove-item-form-{{ $item->id }}').submit();">
                    <svg width="10" height="10" viewBox="0 0 10 10" fill="#767676" xmlns="http://www.w3.org/2000/svg">
                      <path d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                      <path d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                    </svg>
                  </a>
                  </form>
                  </div>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <div class="cart-table-footer">
            <form action="{{ route('wishlist.clear') }}" method="POST" id="clear-wishlist-form">
            @csrf
            @method('DELETE')
                <button type="submit" class="btn btn-light">XÓA DANH SÁCH YÊU THÍCH</button>
            </form>
          </div>
        </div>
        @else
            <div class="row">
                <div class="col-md-12">
                    <p>Không có sản phẩm trong danh sách yêu thích</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-info">Tiếp tục mua sắm</a>
                </div>
            </div>
        @endif
      </div>
    </section>
  </main>

@endsection
