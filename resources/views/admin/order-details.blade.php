@extends('layouts.admin')

@section('content')
<style>
                            .table-transaction>tbody>tr:nth-of-type(odd) {
                                --bs-table-accent-bg: #fff !important;
                            }
                        </style>
                        <div class="main-content-inner">
                            <div class="main-content-wrap">
                                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                                    <h3>Chi Tiết Đơn Hàng</h3>
                                    <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                                        <li>
                                            <a href="{{ route('admin.index') }}">
                                                <div class="text-tiny">Bảng Điều Khiển</div>
                                            </a>
                                        </li>
                                        <li>
                                            <i class="icon-chevron-right"></i>
                                        </li>
                                        <li>
                                            <div class="text-tiny">Chi Tiết Đơn Hàng</div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="wg-box">
                                    <div class="flex items-center justify-between gap10 flex-wrap">
                                        <div class="wg-filter flex-grow">
                                            <h5>Thông Tin Đơn Hàng</h5>
                                        </div>
                                        <a class="tf-button style-1 w208" href="{{ route('admin.orders') }}">Quay Lại</a>
                                    </div>
                                    <div class="table-responsive">
                                    @if(Session::has('status'))
                                        <p class="alert alert-success">{{Session::get('status')}}</p>
                                    @endif
                                    <table class="table table-striped table-bordered">
                                                <tr>
                                                    <th>Mã Đơn Hàng</th>
                                                    <td>{{ $order->id }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Số Điện Thoại</th>
                                                    <td>{{ $order->phone }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Mã Bưu Điện</th>
                                                    <td>{{ $order->zip }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Ngày Đặt Hàng</th>
                                                    <td>{{ $order->created_at->format('d-m-Y H:i:s') }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Ngày Giao Hàng</th>
                                                    <td>{{ $order->delivered_date }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Ngày Hủy</th>
                                                    <td>{{ $order->canceled_date }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Trạng Thái Đơn Hàng</th>
                                                    <td colspan="5">
                                                        @if($order->status == 'delivered')
                                                            <span class="badge bg-success">Đã Giao</span>
                                                        
                                                        @elseif($order->status == 'canceled')
                                                            <span class="badge bg-danger">Đã Hủy</span>

                                                        @else
                                                            <span class="badge bg-warning">Đã Đặt</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                        </table>
                                    </div>

                                </div>

                                <div class="wg-box">
                                    <div class="flex items-center justify-between gap10 flex-wrap">
                                        <div class="wg-filter flex-grow">
                                            <h5>Sản Phẩm Đã Đặt</h5>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Tên</th>
                                                    <th class="text-center">Giá</th>
                                                    <th class="text-center">Số Lượng</th>
                                                    <th class="text-center">Mã SKU</th>
                                                    <th class="text-center">Danh Mục</th>
                                                    <th class="text-center">Thương Hiệu</th>
                                                    <th class="text-center">Tùy Chọn</th>
                                                    <th class="text-center">Trạng Thái Trả Hàng</th>
                                                    <th class="text-center">Thao Tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($orderItems as $item)
                                                <tr>
                                                    <td class="pname">
                                                        <div class="image">
                                                            <img src="{{ asset('uploads/products/thumbnails/')}}/{{ $item->product->image }}" alt="{{$item->product->name}}" class="image">
                                                        </div>
                                                        <div class="name">
                                                            <a href="{{ route('shop.product.details', ['product_slug' => $item->product->slug]) }}" target="_blank"
                                                                class="body-title-2">{{$item->product->name}}</a>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">{{$item->price}}</td>
                                                    <td class="text-center">{{$item->quantity}}</td>
                                                    <td class="text-center">{{$item->product->SKU}}</td>
                                                    <td class="text-center">{{$item->product->category->name}}</td>
                                                    <td class="text-center">{{$item->product->brand->name}}</td>
                                                    <td class="text-center">{{$item->options}}</td>
                                                    <td class="text-center">{{$item->return_status == 0 ? 'Không' : 'Có'}}</td>
                                                    <td class="text-center">
                                                        <div class="list-icon-function view-icon">
                                                            <div class="item eye">
                                                                <i class="icon-eye"></i>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="divider"></div>
                                    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                                        {{$orderItems->links('pagination::bootstrap-5')}}
                                    </div>
                                </div>

                                <div class="wg-box mt-5">
                                    <h5>Địa Chỉ Giao Hàng</h5>
                                    <div class="my-account__address-item col-md-6">
                                        <div class="my-account__address-item__detail">
                                            <p>{{$order->name}}</p>
                                            <p>{{$order->address}}</p>
                                            <p>{{$order->locality}}</p>
                                            <p>{{$order->city}}, {{$order->country}}</p>
                                            <p>{{$order->landmark}}</p>
                                            <p>{{$order->zip}}</p>
                                            <br>
                                            <p>Điện thoại : {{$order->phone}}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="wg-box mt-5">
                                    <h5>Giao Dịch</h5>
                                    <table class="table table-striped table-bordered table-transaction">
                                        <tbody>
                                            <tr>
                                                <th>Tạm Tính</th>
                                                <td>{{$order->subtotal}}</td>
                                                <th>Thuế</th>
                                                <td>{{$order->tax}}</td>
                                                <th>Giảm Giá</th>
                                                <td>{{$order->discount}}</td>
                                            </tr>
                                            <tr>
                                                <th>Tổng Cộng</th>
                                                <td>{{$order->total}}</td>
                                                <th>Phương Thức Thanh Toán</th>
                                                <td>{{$transaction->mode}}</td>
                                                <th>Trạng Thái</th>
                                                <td>
                                                    @if($transaction->status == 'approved')
                                                        <span class="badge bg-success">Đã Duyệt</span>
                                                    @elseif($transaction->status == 'declined')
                                                        <span class="badge bg-danger">Từ Chối</span>
                                                    @elseif($transaction->status == 'refunded')
                                                        <span class="badge bg-warning">Hoàn Tiền</span>
                                                    @else
                                                        <span class="badge bg-warning">Đang Chờ</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>

                                <div class="wg-box mt-5">
                                    <h5>Cập Nhật Trạng Thái Đơn Hàng</h5>
                                    <form action="{{route('admin.order.update.status')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{$order->id}}" />
                                        <div class="row">
                                        <div class="col-md-3">
                                        
                                            <div class="select">
                                            <select id="order_status" name="order_status">
                                                <option value="ordered" {{$order->status == 'ordered' ? "selected":""}}>Đã Đặt</option>
                                                <option value="delivered" {{$order->status == 'delivered' ? "selected":""}}>Đã Giao</option>
                                                <option value="canceled" {{$order->status == 'canceled' ? "selected":""}}>Đã Hủy</option>
                                            </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                        <button type="submit" class="btn btn-primary tf-button w208">Cập Nhật Trạng Thái</button>
                                        </div>
                                        </div>
                                        </form>
                                </div>
                            </div>
                        </div>
@endsection
