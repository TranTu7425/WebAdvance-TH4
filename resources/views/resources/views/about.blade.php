@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/about.css') }}">
@endpush

@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="contact-us container">
      <div class="mw-930">
        <h2 class="page-title">Về Phenikaa Fashion Shop</h2>
      </div>

      <div class="about-us__content pb-5 mb-5">
        <p class="mb-5">
          <img loading="lazy" class="w-75 h-auto d-block mx-auto" src="assets/images/about/about-1.png" width="480"
            height="300" alt="Phenikaa Fashion Shop" />
        </p>
        <div class="mw-930">
          <h3 class="mb-4">CÂU CHUYỆN CỦA CHÚNG TÔI</h3>
          <p class="fs-6 fw-medium mb-4">Chào mừng đến với Phenikaa Fashion Shop, nơi sự thanh lịch gặp gỡ phong cách hiện đại. Được thành lập với niềm đam mê mang đến thời trang chất lượng cao cho khách hàng, chúng tôi đã khẳng định vị thế là điểm đến hàng đầu cho những ai yêu thích thiết kế tinh tế và chất lượng hoàn hảo.</p>
          <p class="mb-4">Tại Phenikaa Fashion Shop, chúng tôi tin rằng thời trang không chỉ là quần áo – đó là một hình thức thể hiện cá tính. Bộ sưu tập được chọn lọc kỹ lưỡng của chúng tôi phản ánh xu hướng mới nhất trong khi vẫn giữ được vẻ đẹp vượt thời gian. Chúng tôi tự hào mang đến đa dạng phong cách phù hợp với nhiều sở thích và dịp khác nhau, đảm bảo mỗi khách hàng đều tìm được phong cách hoàn hảo cho riêng mình.</p>
          <div class="row mb-3">
            <div class="col-md-6">
              <h5 class="mb-3">Sứ Mệnh</h5>
              <p class="mb-3">Mang đến trải nghiệm thời trang tuyệt vời cho khách hàng thông qua các sản phẩm chất lượng cao, dịch vụ cá nhân hóa và cam kết thực hành bền vững trong ngành thời trang.</p>
            </div>
            <div class="col-md-6">
              <h5 class="mb-3">Tầm Nhìn</h5>
              <p class="mb-3">Trở thành điểm đến thời trang hàng đầu được biết đến với phong cách độc đáo, chất lượng thủ công và sự tận tâm với khách hàng, đồng thời thúc đẩy các hoạt động thời trang bền vững.</p>
            </div>
          </div>
        </div>
        <div class="mw-930 d-lg-flex align-items-lg-center">
          <div class="image-wrapper col-lg-6">
            <img class="h-auto" loading="lazy" src="assets/images/about/about-2.jpg" width="450" height="500" alt="Nội thất Phenikaa Fashion Shop">
          </div>
          <div class="content-wrapper col-lg-6 px-lg-4">
            <h5 class="mb-3">Công Ty</h5>
            <p>Phenikaa Fashion Shop là minh chứng cho cam kết của chúng tôi về sự xuất sắc trong bán lẻ thời trang. Cửa hàng của chúng tôi cung cấp một loạt các sản phẩm được lựa chọn kỹ lưỡng bao gồm quần áo, phụ kiện và các sản phẩm phong cách sống thể hiện sự thanh lịch đương đại. Chúng tôi làm việc chặt chẽ với các nhà thiết kế và thương hiệu nổi tiếng để mang đến cho bạn những món thời trang tinh tế nhất, kết hợp giữa chất lượng, phong cách và sự thoải mái.</p>
          </div>
        </div>

        <!-- Privacy Policy Section -->
        <div class="mw-930 mt-5">
          <h3 class="mb-4">Chính Sách Bảo Mật</h3>
          <p class="mb-4">Tại Phenikaa Fashion Shop, chúng tôi coi trọng quyền riêng tư của bạn. Chúng tôi cam kết bảo vệ thông tin cá nhân và đảm bảo trải nghiệm mua sắm an toàn. Chính sách bảo mật của chúng tôi nêu rõ cách chúng tôi thu thập, sử dụng và bảo vệ dữ liệu của bạn:</p>
          <ul class="mb-4">
            <li>Chúng tôi chỉ thu thập thông tin cần thiết để xử lý đơn hàng và cải thiện trải nghiệm mua sắm của bạn</li>
            <li>Dữ liệu cá nhân của bạn được mã hóa và lưu trữ an toàn</li>
            <li>Chúng tôi không bao giờ chia sẻ thông tin của bạn với bên thứ ba mà không có sự đồng ý của bạn</li>
            <li>Bạn có quyền truy cập, sửa đổi hoặc xóa thông tin cá nhân của mình</li>
          </ul>
        </div>

        <!-- Terms & Conditions Section -->
        <div class="mw-930 mt-5">
          <h3 class="mb-4">Điều Khoản & Điều Kiện</h3>
          <p class="mb-4">Khi mua sắm tại Phenikaa Fashion Shop, bạn đồng ý với các điều khoản và điều kiện của chúng tôi:</p>
          <ul class="mb-4">
            <li>Tất cả giá cả có thể thay đổi mà không cần thông báo trước</li>
            <li>Sản phẩm phụ thuộc vào tình trạng tồn kho</li>
            <li>Chúng tôi có quyền từ chối phục vụ bất kỳ ai</li>
            <li>Đổi trả và hoàn tiền phải được thực hiện trong vòng 30 ngày kể từ ngày mua</li>
            <li>Tất cả sản phẩm phải còn nguyên tình trạng ban đầu và còn tem mác để được đổi trả</li>
          </ul>
        </div>
      </div>
    </section>
  </main>
@endsection 