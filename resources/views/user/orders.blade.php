@extends('layouts.app')

@section('content')
<style>
    .table> :not(caption)>tr>th {
      padding: 0.625rem 1.5rem .625rem !important;
      background-color: #6a6e51 !important;
    }

    .table>tr>td {
      padding: 0.625rem 1.5rem .625rem !important;
    }

    .table-bordered> :not(caption)>tr>th,
    .table-bordered> :not(caption)>tr>td {
      border-width: 1px 1px;
      border-color: #6a6e51;
    }

    .table> :not(caption)>tr>td {
      padding: .8rem 1rem !important;
    }
    .bg-success {
      background-color: #40c710 !important;
    }

    .bg-danger {
      background-color: #f44032 !important;
    }

    .bg-warning {
      background-color: #f5d700 !important;
      color: #000;
    }

    /* New styles for better margins and alignment */
    .my-account {
      margin: 2rem auto;
      max-width: 1200px;
    }

    .account-nav {
      margin-bottom: 2rem;
      padding-left: 1rem;
    }

    .account-nav li {
      margin-bottom: 0.5rem;
    }

    .wg-table {
      margin: 1rem 0;
    }

    .table-responsive {
      margin: 0;
      padding: 0;
    }

    .page-title {
      margin-bottom: 2rem;
      padding-left: 1rem;
    }

    .divider {
      margin: 2rem 0;
    }
  </style>
<main class="pt-90" style="padding-top: 0px;">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
        <h2 class="page-title">Đơn Hàng</h2>
        <div class="row">
            <div class="col-lg-2">
                @include('user.account-nav')
        </div>

            <div class="col-lg-10">
                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 80px">Mã Đơn</th>
                                    <th>Tên</th>
                                    <th class="text-center">Điện Thoại</th>
                                    <th class="text-center">Tạm Tính</th>
                                    <th class="text-center">Thuế</th>
                                    <th class="text-center">Tổng Cộng</th>
                                    <th class="text-center">Trạng Thái</th>
                                    <th class="text-center">Ngày Đặt</th>
                                    <th class="text-center">Số Món</th>
                                    <th class="text-center">Ngày Giao</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                <tr>
                                    <td class="text-center">{{ $order->id }}</td>  
                                    <td class="text-center">{{ $order->name }}</td>
                                    <td class="text-center">{{ $order->phone }}</td>
                                    <td class="text-center">{{ $order->subtotal }}</td>
                                    <td class="text-center">{{ $order->tax }}</td>
                                    <td class="text-center">{{ $order->total }}</td>
                                    <td class="text-center">
                                    @if($order->status == 'delivered')
                                        <span class="badge bg-success">Đã Giao</span>
                                    @elseif($order->status == 'canceled')
                                        <span class="badge bg-danger">Đã Hủy</span>
                                    @else
                                        <span class="badge bg-warning">Đã Đặt</span>
                                    @endif
                                    </td>
                                    <td class="text-center">{{ $order->created_at }}</td>
                                    <td class="text-center">{{ $order->orderItems->count() }}</td>
                                    <td class="text-center">{{ $order->delivered_date }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('user.order.details', ['order_id' => $order->id]) }}">
                                        <div class="list-icon-function view-icon">
                                            <div class="item eye">
                                                <i class="fa fa-eye"></i>
                                            </div>                                        
                                        </div>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>                
                    </div>
                </div>
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">       
                    {{ $orders->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
