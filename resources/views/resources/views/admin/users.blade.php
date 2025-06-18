@extends('layouts.admin')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Người dùng</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('admin.index') }}">
                        <div class="text-tiny">Bảng điều khiển</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Tất cả người dùng</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <form class="form-search" action="{{ route('admin.users') }}" method="GET">
                        <fieldset class="name">
                            <input type="text" placeholder="Tìm kiếm..." class="" name="search"
                                value="{{ request('search') }}" aria-required="true">
                        </fieldset>
                        <div class="button-submit">
                            <button class="" type="submit"><i class="icon-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="wg-table table-all-user">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Người dùng</th>
                                <th>Số điện thoại</th>
                                <th>Email</th>
                                <th class="text-center">Tổng đơn hàng</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td class="pname">
                                    <div class="image">
                                        <img src="{{ $user->avatar ?? asset('images/default-avatar.png') }}" alt="{{ $user->name }}" class="image">
                                    </div>
                                    <div class="name">
                                        <a href="#" class="body-title-2">{{ $user->name }}</a>
                                        <div class="text-tiny mt-3">{{ strtoupper(substr($user->name, 0, 3)) }}</div>
                                    </div>
                                </td>
                                <td>{{ $user->phone ?? 'N/A' }}</td>
                                <td>{{ $user->email }}</td>
                                <td class="text-center">
                                    <a href="#" target="_blank">{{ $user->orders_count ?? 0 }}</a>
                                </td>
                                <td>
                                    <div class="list-icon-function">
                                        <a href="#">
                                            <div class="item edit">
                                                <i class="icon-edit-3"></i>
                                            </div>
                                        </a>
                                        <form action="{{ route('admin.user.delete', $user->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="item delete" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')">
                                                <i class="icon-trash-2"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="divider"></div>
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection