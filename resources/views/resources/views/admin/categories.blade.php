@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
                            <div class="main-content-wrap">
                                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                                    <h3>Danh Mục</h3>
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
                                            <div class="text-tiny">Danh Mục</div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="wg-box">
                                    <div class="flex items-center justify-between gap10 flex-wrap">
                                        <div class="wg-filter flex-grow">
                                            <form class="form-search">
                                                <fieldset class="name">
                                                    <input type="text" placeholder="Tìm kiếm..." class="" name="name"
                                                        tabindex="2" value="" aria-required="true" required="">
                                                </fieldset>
                                                <div class="button-submit">
                                                    <button class="" type="submit"><i class="icon-search"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                        <a class="tf-button style-1 w208" href="{{ route('admin.category.add') }}"><i
                                                class="icon-plus"></i>Thêm mới</a>
                                    </div>
                                    <div class="wg-table table-all-user">
                                        <div class="table-responsive">
                                            @if(Session::has('status'))
                                                <div class="alert alert-success">{{ Session::get('status') }}</div>
                                            @endif
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Tên</th>
                                                        <th>Đường Dẫn</th>
                                                        <th>Sản Phẩm</th>
                                                        <th>Thao Tác</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($categories as $category)
                                                    <tr>
                                                        <td>{{ $category->id }}</td>
                                                        <td class="pname">
                                                            <div class="image">
                                                                <img src="{{ asset('uploads/categories/') }}/{{ $category->image }}" alt="{{ $category->name }}" class="image">
                                                            </div>
                                                            <div class="name">
                                                                <a href="#" class="body-title-2">{{ $category->name }}</a>
                                                            </div>
                                                        </td>
                                                        <td>{{ $category->slug }}</td>
                                                        <td><a href="#" target="_blank">{{ $category->products->count() }}</a></td>
                                                        <td>
                                                            <div class="list-icon-function">
                                                                <a href="{{ route('admin.category.edit', ['id' => $category->id]) }}">
                                                                    <div class="item edit">
                                                                        <i class="icon-edit-3"></i>
                                                                    </div>
                                                                </a>
                                                                <form action="{{ route('admin.category.delete', ['id' => $category->id]) }}" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <div class="item text-danger delete">
                                                                        <i class="icon-trash-2"></i>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="divider"></div>
                                        <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                                            {{ $categories->links('pagination::bootstrap-5') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
@endsection

@push('scripts')
<script>
    $(function(){
        $('.delete').on('click', function(e){
            e.preventDefault();
            var form = $(this).closest('form');
            swal({
                title: 'Bạn có chắc chắn?',
                text: 'Bạn có chắc chắn muốn xóa danh mục này?',
                type: 'warning',
                buttons: ['Hủy', 'Xóa'],
                confirmButtonColor: '#3085d6',
            }).then(function(result){
                if(result){
                    form.submit();
                }
            });
        });
    });
</script>
@endpush