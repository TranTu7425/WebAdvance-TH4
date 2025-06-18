@extends('layouts.app')

@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
        <h2 class="page-title">Địa chỉ của tôi</h2>
        <div class="row">
            <div class="col-lg-3">
                @include('user.account-nav')
            </div>
            <div class="col-lg-9">
                <div class="page-content my-account__address">
                    <div class="row">
                        <div class="col-6">
                            <p class="notice">Các địa chỉ sau sẽ được sử dụng mặc định trên trang thanh toán.</p>
                        </div>
                        <div class="col-6 text-right">
                            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#addAddressModal">
                                Thêm mới
                            </button>
                        </div>
                    </div>

                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    <div class="my-account__address-list row">
                        <h5>Địa chỉ giao hàng</h5>

                        @forelse($addresses as $address)
                        <div class="my-account__address-item col-md-6">
                            <div class="my-account__address-item__title">
                                <h5>{{ $address->name }} 
                                    @if($address->is_default)
                                    <i class="fa fa-check-circle text-success"></i>
                                    @endif
                                </h5>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                            data-toggle="modal" 
                                            data-target="#editAddressModal{{ $address->id }}">
                                        Chỉnh sửa
                                    </button>
                                    <form action="{{ route('addresses.destroy', $address) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa địa chỉ này?')">
                                            Xóa
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="my-account__address-item__detail">
                                <p>{{ $address->address_line1 }}</p>
                                @if($address->address_line2)
                                <p>{{ $address->address_line2 }}</p>
                                @endif
                                <p>{{ $address->city }}, {{ $address->state }}</p>
                                @if($address->landmark)
                                <p>{{ $address->landmark }}</p>
                                @endif
                                <p>{{ $address->postal_code }}</p>
                                <br>
                                <p>Số điện thoại: {{ $address->phone }}</p>
                            </div>
                        </div>

                        <!-- Edit Address Modal -->
                        <div class="modal fade" id="editAddressModal{{ $address->id }}" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Chỉnh sửa địa chỉ</h5>
                                        <button type="button" class="close" data-dismiss="modal">
                                            <span>&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('addresses.update', $address) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Tên người nhận</label>
                                                <input type="text" name="name" class="form-control" value="{{ $address->name }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Địa chỉ dòng 1</label>
                                                <input type="text" name="address_line1" class="form-control" value="{{ $address->address_line1 }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Địa chỉ dòng 2</label>
                                                <input type="text" name="address_line2" class="form-control" value="{{ $address->address_line2 }}">
                                            </div>
                                            <div class="form-group">
                                                <label>Thành phố</label>
                                                <input type="text" name="city" class="form-control" value="{{ $address->city }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Tỉnh/Thành</label>
                                                <input type="text" name="state" class="form-control" value="{{ $address->state }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Mã bưu điện</label>
                                                <input type="text" name="postal_code" class="form-control" value="{{ $address->postal_code }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Địa điểm tham chiếu</label>
                                                <input type="text" name="landmark" class="form-control" value="{{ $address->landmark }}">
                                            </div>
                                            <div class="form-group">
                                                <label>Số điện thoại</label>
                                                <input type="text" name="phone" class="form-control" value="{{ $address->phone }}" required>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="is_default" class="custom-control-input" id="isDefault{{ $address->id }}" value="1" {{ $address->is_default ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="isDefault{{ $address->id }}">Đặt làm địa chỉ mặc định</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <p>Bạn chưa có địa chỉ nào được lưu.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Add Address Modal -->
<div class="modal fade" id="addAddressModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm địa chỉ mới</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('addresses.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tên người nhận</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Địa chỉ dòng 1</label>
                        <input type="text" name="address_line1" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Địa chỉ dòng 2</label>
                        <input type="text" name="address_line2" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Thành phố</label>
                        <input type="text" name="city" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Tỉnh/Thành</label>
                        <input type="text" name="state" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Mã bưu điện</label>
                        <input type="text" name="postal_code" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Địa điểm tham chiếu</label>
                        <input type="text" name="landmark" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="is_default" class="custom-control-input" id="isDefault" value="1">
                            <label class="custom-control-label" for="isDefault">Đặt làm địa chỉ mặc định</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Thêm địa chỉ</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 