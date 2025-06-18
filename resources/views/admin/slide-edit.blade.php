@extends('layouts.admin')

@section('content')
<div class="main-content-inner">
                            <!-- main-content-wrap -->
                            <div class="main-content-wrap">
                                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                                    <h3>Chỉnh sửa Slide</h3>
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
                                            <a href="{{ route('admin.slide.add') }}">
                                                <div class="text-tiny">Slides</div>
                                            </a>
                                        </li>
                                        <li>
                                            <i class="icon-chevron-right"></i>
                                        </li>
                                        <li>
                                            <div class="text-tiny">Chỉnh sửa Slide</div>
                                        </li>
                                    </ul>
                                </div>
                                <!-- new-category -->
                                <div class="wg-box">
                                    <form class="form-new-product form-style-1" action="{{ route('admin.slide.update') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="id" value="{{ $slide->id }}">
                                        <fieldset class="name">
                                            <div class="body-title">Dòng tag <span class="tf-color-1">*</span></div>
                                            <input class="flex-grow" type="text" placeholder="Dòng tag" name="tagline" tabindex="0" value="{{ $slide->tagline }}" aria-required="true" required="">                                            
                                        </fieldset>
                                        @error('tagline')
                                                <span class="alert alert-danger text-center">{{ $message }}</span>
                                            @enderror
                                        <fieldset class="name">
                                            <div class="body-title">Tiêu đề <span class="tf-color-1">*</span></div>
                                                <input class="flex-grow" type="text" placeholder="Tiêu đề" name="title" tabindex="0" value="{{ $slide->title }}" aria-required="true" required="">
                                        </fieldset>
                                        @error('title')
                                                <span class="alert alert-danger text-center">{{ $message }}</span>
                                            @enderror
                                        <fieldset class="name">
                                            <div class="body-title">Phụ đề <span class="tf-color-1">*</span></div>
                                            <input class="flex-grow" type="text" placeholder="Phụ đề" name="subtitle" tabindex="0" value="{{ $slide->subtitle }}" aria-required="true" required="">
                                        </fieldset>
                                        @error('subtitle')
                                                <span class="alert alert-danger text-center">{{ $message }}</span>
                                            @enderror
                                        <fieldset class="name">
                                            <div class="body-title">Liên kết <span class="tf-color-1">*</span></div>
                                            <input class="flex-grow" type="text" placeholder="Liên kết" name="link" tabindex="0" value="{{ $slide->link }}" aria-required="true" required="">
                                        </fieldset>
                                        @error('link')
                                                <span class="alert alert-danger text-center">{{ $message }}</span>
                                            @enderror
                                        <fieldset>
                                            <div class="body-title">Tải lên hình ảnh <span class="tf-color-1">*</span>
                                            </div>
                                            <div class="upload-image flex-grow">
                                                @if($slide->image)
                                                <div class="item" id="imgpreview">
                                                    <img src="{{ asset('uploads/slides/')}}/{{$slide->image }}" alt="" class="effect8">
                                                </div>
                                                @endif
                                                <div class="item up-load">
                                                    <label class="uploadfile" for="myFile">
                                                        <span class="icon">
                                                            <i class="icon-upload-cloud"></i>
                                                        </span>
                                                        <span class="body-text">Kéo thả hình ảnh vào đây hoặc chọn <span
                                                                class="tf-color">nhấp để duyệt</span></span>
                                                        <input type="file" id="myFile" name="image">
                                                    </label>
                                                </div>
                                            </div>
                                        </fieldset>
                                        @error('image')
                                                <span class="alert alert-danger text-center">{{ $message }}</span>
                                            @enderror
                                        <fieldset class="category">
                                            <div class="body-title">Trạng thái</div>
                                            <div class="select flex-grow">
                                                <select class="" name="status">
                                                    <option value="">Chọn</option>
                                                    <option value="1" @if($slide->status == "1") selected @endif>Hoạt động</option>
                                                    <option value="0" @if($slide->status == "0") selected @endif>Không hoạt động</option>
                                                </select>
                                            </div>
                                        </fieldset>
                                        @error('status')
                                                <span class="alert alert-danger text-center">{{ $message }}</span>
                                            @enderror
                                        <div class="bot">
                                            <div></div>
                                            <button class="tf-button w208" type="submit">Lưu</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- /new-category -->
                            </div>
                            <!-- /main-content-wrap -->
                        </div>
@endsection

@push('scripts')
<script>
    $(function(){
        $("#myFile").on("change", function(e){
            const [file] = this.files;
            if (file) {
                $("#imgpreview img").attr('src', URL.createObjectURL(file));
                $("#imgpreview").show();
            } 
        });

        
    });

</script>

@endpush